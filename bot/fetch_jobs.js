import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import fs from 'fs';
import path from 'path';
puppeteer.use(StealthPlugin());

(async () => {
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

    const { platform, session_dir, preferences } = inputData;
    const { target_roles, target_locations, remote_preference, max_job_age_days } = preferences;

    const roles = target_roles ? target_roles.split(',').map(r => r.trim()).filter(r => r) : ['Software Engineer'];
    const locations = target_locations ? target_locations.split(',').map(l => l.trim()).filter(l => l) : [];

    let searchQueries = [];
    roles.forEach(role => {
        if (remote_preference === 'only') {
            searchQueries.push({ role, location: 'Remote' });
        } else {
            if (locations.length > 0) {
                locations.forEach(location => {
                    searchQueries.push({ role, location });
                });
            } else if (remote_preference === 'none') {
                 searchQueries.push({ role, location: '' });
            }
            
            if (remote_preference === 'include') {
                searchQueries.push({ role, location: 'Remote' });
            }
        }
    });

    try {
        const launchOptions = { 
            headless: 'new', 
            defaultViewport: null,
            env: {
                ...process.env,
                XDG_CONFIG_HOME: '/tmp',
                XDG_CACHE_HOME: '/tmp'
            }
        };
        
        if (process.env.DOCKER_ENV) {
            launchOptions.args = [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-crash-reporter',
                '--disable-gpu',
                '--disable-software-rasterizer'
            ];
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH || '/usr/bin/chromium';
        }
        
        if (process.env.PUPPETEER_EXECUTABLE_PATH) {
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH;
        }

        const browser = await puppeteer.launch(launchOptions);
        
        const page = await browser.newPage();
        
        // Inject cookies if session exists
        if (session_dir) {
            const cookieFile = path.join(session_dir, 'cookies.json');
            if (fs.existsSync(cookieFile)) {
                try {
                    const cookies = JSON.parse(fs.readFileSync(cookieFile, 'utf8'));
            
            // Clean cookies to prevent CDP Protocol errors
            const cleanCookies = cookies.map(cookie => {
                const { name, value, domain, path, secure, httpOnly, sameSite } = cookie;
                const validCookie = { name, value, domain, path, secure, httpOnly };
                
                if (cookie.expirationDate) validCookie.expires = cookie.expirationDate;
                else if (cookie.expires) validCookie.expires = cookie.expires;
                
                if (sameSite) {
                    const normalizedSameSite = sameSite.charAt(0).toUpperCase() + sameSite.slice(1).toLowerCase();
                    if (['Strict', 'Lax', 'None'].includes(normalizedSameSite)) {
                        validCookie.sameSite = normalizedSameSite;
                    }
                }
                return validCookie;
            });
            
            await page.setCookie(...cleanCookies);
                    console.error(`[DEBUG] Loaded cookies from ${cookieFile}`);
                } catch (e) {
                    console.error(`[DEBUG] Failed to load cookies: ${e.message}`);
                }
            }
        }
        
        let allJobs = [];

        for (const query of searchQueries) {
            // Build Search URL based on platform
            let searchUrl = '';
            let jobSelector = '';
            
            const keyword = encodeURIComponent(query.role);
            const loc = encodeURIComponent(query.location);

            switch (platform) {
                case 'INDEED':
                    searchUrl = `https://www.indeed.com/jobs?q=${keyword}&l=${loc}`;
                    jobSelector = '.job_seen_beacon';
                    break;
                case 'LINKEDIN':
                    // LinkedIn "All Jobs" search
                    // remote filter: f_WT=2 (Remote)
                    let timeFilter = '';
                    if (max_job_age_days == 1) {
                        timeFilter = '&f_TPR=r86400';
                    } else if (max_job_age_days == 7) {
                        timeFilter = '&f_TPR=r604800';
                    } else if (max_job_age_days == 30) {
                        timeFilter = '&f_TPR=r2592000';
                    }
                    
                    const remoteParam = (remote_preference === 'only' || query.location === 'Remote') ? '&f_WT=2' : '';
                    searchUrl = `https://www.linkedin.com/jobs/search/?keywords=${keyword}&location=${loc}${remoteParam}${timeFilter}`;
                    jobSelector = 'li, .job-card-container, .job-search-card';
                    break;
                case 'NAUKRI':
                    searchUrl = `https://www.naukri.com/${keyword.replace(/%20/g, '-')}-jobs-in-${loc.replace(/%20/g, '-')}`;
                    jobSelector = '.srp-jobtuple-wrapper';
                    break;
                case 'UPLERS':
                    searchUrl = `https://app.uplers.com/jobs?search=${keyword}`;
                    jobSelector = '.job-card';
                    break;
                case 'UNSTOP':
                    searchUrl = `https://unstop.com/jobs?query=${keyword}`;
                    jobSelector = '.opportunity-card';
                    break;
                case 'HIRIST':
                    searchUrl = `https://www.hirist.tech/search/${keyword.replace(/%20/g, '-')}`;
                    jobSelector = '.job-item';
                    break;
                case 'CUTSHORT':
                    searchUrl = `https://cutshort.io/jobs?q=${keyword}`;
                    jobSelector = '.job-card';
                    break;
                default:
                    throw new Error('Unknown platform');
            }

            try {
                // Set a realistic User-Agent to avoid immediate flagging
                await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
                await page.goto(searchUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
                
                // Wait a bit for dynamic content
                await new Promise(r => setTimeout(r, 3000));
                
                // Scroll 3 times to trigger infinite loading/lazy-loaded images
                for (let i = 0; i < 3; i++) {
                    await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
                    await new Promise(r => setTimeout(r, 2000));
                }
                
                const jobs = await page.evaluate((sel, plat) => {
                    const jobNodes = document.querySelectorAll(sel);
                    const extracted = [];
                    
                    jobNodes.forEach(node => {
                        let url = '', title = 'Unknown', company = 'Unknown', location = 'Unknown';
                        
                        // Rough extraction logic (these selectors would need constant updating in reality)
                        if (plat === 'LINKEDIN') {
                            const link = node.querySelector('a[href*="/jobs/view/"], .job-card-list__title, .base-card__full-link');
                            if (link) {
                                url = link.href;
                                title = link.innerText.trim() || 'Software Engineer';
                            }
                            const comp = node.querySelector('.job-card-container__primary-description, .hidden-nested-link, .base-search-card__subtitle, .artdeco-entity-lockup__subtitle');
                            if (comp) company = comp.innerText.trim();
                            const loc = node.querySelector('.job-card-container__metadata-item, .job-search-card__location, .artdeco-entity-lockup__caption');
                            if (loc) location = loc.innerText.trim();
                        } else if (plat === 'INDEED') {
                            const link = node.querySelector('h2.jobTitle a');
                            if (link) {
                                url = link.href;
                                title = link.querySelector('span') ? link.querySelector('span').innerText : link.innerText;
                            }
                            const comp = node.querySelector('[data-testid="company-name"]');
                            if (comp) company = comp.innerText.trim();
                            const locationNode = node.querySelector('[data-testid="text-location"]');
                            if (locationNode) location = locationNode.innerText.trim();
                        } else {
                            // Generic fallback mock
                            url = node.querySelector('a') ? node.querySelector('a').href : window.location.href;
                            title = node.innerText.split('\n')[0];
                        }
                        
                        // Clean URL to remove tracking params (essential for unique constraint)
                        if (url) {
                            try {
                                const parsedUrl = new URL(url);
                                url = parsedUrl.origin + parsedUrl.pathname;
                            } catch (e) {}
                            extracted.push({ url, title, company, location });
                        }
                    });
                    
                    return { extracted, nodeCount: jobNodes.length, pageTitle: document.title };
                }, jobSelector, platform);

                console.error(`[DEBUG] Page title: ${jobs.pageTitle}, Nodes found: ${jobs.nodeCount}`);
                allJobs.push(...jobs.extracted);

            } catch (err) {
                console.error(`Error searching ${query.role}: ${err.message}`);
                try {
                    // Capture screenshot on failure
                    const timestamp = new Date().getTime();
                    const screenshotPath = `${session_dir}/failure_${platform}_${timestamp}.png`;
                    await page.screenshot({ path: screenshotPath, fullPage: true });
                    console.error(`[DEBUG] Saved failure screenshot to ${screenshotPath}`);
                } catch (e) {
                    console.error('Failed to take screenshot on error.');
                }
            }
        }

        // We no longer strictly filter by regex because it was throwing away valid jobs
        // like "Software Developer" when searching for "Software Engineer".
        // Instead, we trust the platform's search results and just deduplicate by URL.
        const uniqueJobs = Array.from(new Map(allJobs.map(item => [item.url, item])).values());
        
        await browser.close();
        
        console.log(JSON.stringify({ status: 'success', jobs: uniqueJobs }));
        
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: error.message }));
        process.exit(1);
    }
})();
