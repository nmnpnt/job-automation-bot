import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import fs from 'fs';
import path from 'path';
import os from 'os';

process.on('uncaughtException', (err) => {
    if (err.message && err.message.includes('Requesting main frame too early')) return;
    console.error(`Uncaught Exception: ${err.message}`);
});

process.on('unhandledRejection', (reason, promise) => {
    if (reason && reason.message && reason.message.includes('Requesting main frame too early')) return;
});

puppeteer.use(StealthPlugin());

(async () => {
    let browser;
    process.on('SIGTERM', async () => {
        if (browser) await browser.close();
        process.exit(0);
    });

    const args = process.argv.slice(2);
    if (args.length === 0) {
        console.error(JSON.stringify({ status: 'failed', message: 'No input provided' }));
        process.exit(1);
    }

    let inputData;
    try {
        inputData = JSON.parse(args[0]);
    } catch (e) {
        console.error(JSON.stringify({ status: 'failed', message: 'Invalid JSON input' }));
        process.exit(1);
    }

    const { url, platform, session_dir } = inputData;

    try {
        const launchOptions = { 
            headless: 'new', 
            defaultViewport: null,
            env: {
                ...process.env,
                XDG_CONFIG_HOME: os.tmpdir(),
                XDG_CACHE_HOME: os.tmpdir()
            }
        };
        
        if (process.env.DOCKER_ENV || inputData.is_docker) {
            launchOptions.args = [
                '--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage',
                '--disable-crash-reporter', '--disable-gpu', '--disable-software-rasterizer'
            ];
            launchOptions.userDataDir = '/tmp/puppeteer_data';
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH || '/usr/bin/chromium';
        }
        
        if (process.env.PUPPETEER_EXECUTABLE_PATH) {
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH;
        } else {
            const possibleChromePaths = [
                'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
                'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
                '/usr/bin/chromium', '/usr/bin/chromium-browser', '/usr/bin/google-chrome'
            ];
            for (const p of possibleChromePaths) {
                if (fs.existsSync(p)) { launchOptions.executablePath = p; break; }
            }
        }

        browser = await puppeteer.launch(launchOptions);
        const page = await browser.newPage();
        
        // Inject cookies if session exists
        if (session_dir) {
            const cookieFile = path.join(session_dir, 'cookies.json');
            if (fs.existsSync(cookieFile)) {
                try {
                    const cookies = JSON.parse(fs.readFileSync(cookieFile, 'utf8'));
                    await page.setCookie(...cookies);
                } catch (e) {}
            }
        }

        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        
        let targetUrl = url;
        if (url.includes('linkedin.com/jobs')) {
            const viewMatch = url.match(/view\/(\d+)/);
            const idMatch = url.match(/currentJobId=(\d+)/);
            const jobId = viewMatch ? viewMatch[1] : (idMatch ? idMatch[1] : null);
            if (jobId) {
                targetUrl = `https://www.linkedin.com/jobs-guest/jobs/api/jobPosting/${jobId}`;
            }
        }

        await page.goto(targetUrl, { waitUntil: 'networkidle2', timeout: 45000 });
        await new Promise(r => setTimeout(r, 3000)); // Extra wait for React/Angular hydration
        
        // Scroll to load dynamic content
        for (let i = 0; i < 3; i++) {
            await page.evaluate((step) => window.scrollTo(0, document.body.scrollHeight / 3 * (step+1)), i);
            await new Promise(r => setTimeout(r, 1000));
        }

        const details = await page.evaluate(async (plat) => {
            let description = '';
            let skills = '';
            
            // Helper function to format list items with bullets before getting innerText
            const formatNodeText = (node) => {
                if (!node) return '';
                const listItems = node.querySelectorAll('li');
                listItems.forEach(li => {
                    const text = li.innerText.trim();
                    if (text && !text.startsWith('•') && !text.startsWith('-')) {
                        li.innerText = '• ' + li.innerText;
                    }
                });
                return node.innerText.trim();
            };
            
            // Retry loop inside browser context for slow SPAs
            for (let attempt = 0; attempt < 5; attempt++) {
                if (plat === 'LINKEDIN' || window.location.href.includes('linkedin.com')) {
                    const descNode = document.querySelector('.jobs-description-content__text, .show-more-less-html__markup, .description__text');
                    if (descNode) description = formatNodeText(descNode);
                    if (!description) description = document.body.innerText.trim();
                } else if (plat === 'INDEED') {
                    const descNode = document.querySelector('#jobDescriptionText');
                    if (descNode) description = formatNodeText(descNode);
                } else {
                    // Try specific selectors for other known job boards
                    const specificSelectors = [
                        '.job-desc', 'section.job-desc', '.dang-inner-html', 
                        '[class*="styles_job-desc-container__"]', '[class*="styles_JDC__"]', '[class*="JobDescription"]', // Naukri
                        '.job-detail-content', // Uplers
                        '.competition-details', '.detail-container', // Unstop
                        '.job-details-wrapper', // Hirist
                        '.job-desc-content', '.job-details-container', // Cutshort
                        '#content', 'div[id="content"]', '.job__description', // Greenhouse
                        '.section-wrapper.page-full-width', // Lever
                        '#JobDescriptionContainer', '.jobDescriptionContent', // Glassdoor
                        '[data-automation-id="jobPostingDescription"]', // Workday
                        '#about-role', '[data-test="JobProfileAbout"]', // Wellfound / AngelList
                    ];

                    for (const selector of specificSelectors) {
                        const node = document.querySelector(selector);
                        if (node && node.innerText.length > 100) {
                            description = formatNodeText(node);
                            break;
                        }
                    }
                    
                    if (!description) {
                        // Also try matching by partial class name (for hashed modules like Naukri)
                        const partialNodes = document.querySelectorAll('[class*="job-desc"], [class*="JobDesc"]');
                        for (const pNode of partialNodes) {
                            if (pNode && pNode.innerText.length > 200) {
                                description = formatNodeText(pNode);
                                break;
                            }
                        }
                    }

                    // Fallback: Try to grab main content body
                    if (!description) {
                        const contentNodes = document.querySelectorAll('main, article, .job-description, .description, #job-details');
                        for (const node of contentNodes) {
                            if (node && node.innerText.length > 200) {
                                description = formatNodeText(node);
                                break;
                            }
                        }
                    }
                    
                    // Absolute fallback to body text if no structured container is found
                    if (!description) {
                        const bodyText = document.body.innerText.trim();
                        if (bodyText.length > 200) {
                            description = bodyText.substring(0, 5000); // Grab up to 5k chars to avoid crashing
                        }
                    }
                }
                
                if (description && description.length > 100) {
                    break;
                }
                
                // Wait 1 second before retrying inside browser context
                await new Promise(r => setTimeout(r, 1000));
            }

            return { description, skills };
        }, platform);
        
        await browser.close();
        
        console.log(JSON.stringify({ 
            status: 'success', 
            details: details 
        }));
        
    } catch (error) {
        if (browser) await browser.close();
        console.error(JSON.stringify({ status: 'failed', message: error.message }));
        process.exit(1);
    }
})();
