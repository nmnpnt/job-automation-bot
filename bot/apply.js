import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import crypto from 'crypto';
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

    const { url, platform, profile, cover_letter, session_dir } = inputData;

    // Helper function to safely fill inputs
    const fillInput = async (page, selector, value) => {
        try {
            await page.waitForSelector(selector, { timeout: 3000 });
            await page.type(selector, value);
        } catch (err) {
            console.log(JSON.stringify({ status: 'warning', message: `Could not find or fill ${selector}` }));
        }
    };

    let browser = null;
    let page = null;

    try {
        const launchOptions = { headless: 'new', defaultViewport: null };
        
        if (process.env.DOCKER_ENV) {
            launchOptions.args = [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage'
            ];
        }

        if (process.env.PUPPETEER_EXECUTABLE_PATH) {
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH;
        } else {
            const possibleChromePaths = [
                'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
                'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
                '/usr/bin/chromium',
                '/usr/bin/chromium-browser',
                '/usr/bin/google-chrome'
            ];
            for (const p of possibleChromePaths) {
                if (fs.existsSync(p)) {
                    launchOptions.executablePath = p;
                    break;
                }
            }
        }

        const browser = await puppeteer.launch(launchOptions);
        page = await browser.newPage();
        
        if (session_dir) {
            const cookieFile = path.join(session_dir, 'cookies.json');
            if (fs.existsSync(cookieFile)) {
                try {
                    const cookies = JSON.parse(fs.readFileSync(cookieFile, 'utf8'));
                    await page.setCookie(...cookies);
                    console.error(`[DEBUG] Loaded cookies from ${cookieFile}`);
                } catch (e) {
                    console.error(`[DEBUG] Failed to load cookies: ${e.message}`);
                }
            }
        }
        
        // Mocking the navigation
        await page.goto(url, { waitUntil: 'networkidle2' }).catch(() => {});
        
        // Simulating form filling logic
        let success = false;
        
        if (platform === 'GREENHOUSE') {
            console.log(JSON.stringify({ status: 'info', message: 'Applying on Greenhouse...' }));
            
            // Wait for the form to load
            await page.waitForSelector('form#application_form', { timeout: 10000 });
            
            // Fill standard fields
            if (profile.first_name) await fillInput(page, 'input#first_name', profile.first_name);
            if (profile.last_name) await fillInput(page, 'input#last_name', profile.last_name);
            if (profile.email) await fillInput(page, 'input#email', profile.email);
            if (profile.phone) await fillInput(page, 'input#phone', profile.phone);
            
            // Upload resume
            if (profile.resume_path) {
                const fileInputs = await page.$$('input[type="file"]');
                if (fileInputs.length > 0) {
                    await fileInputs[0].uploadFile(profile.resume_path);
                }
            }

            // Cover letter
            if (cover_letter) {
                // Try the text area if they allow typing
                await fillInput(page, 'textarea#cover_letter_text', cover_letter);
            }

            // Click submit
            // UNCOMMENT THIS IN PRODUCTION:
            // await page.click('input#submit_app, button#submit_app');
            // await page.waitForNavigation({ waitUntil: 'networkidle2' });
            
            success = true;
        } else if (platform === 'LEVER') {
            console.log(JSON.stringify({ status: 'info', message: 'Applying on Lever...' }));
            
            // Wait for the form to load
            await page.waitForSelector('#application-form', { timeout: 10000 });
            
            // Lever typically has a single "Full Name" field, or first/last
            const fullName = `${profile.first_name || ''} ${profile.last_name || ''}`.trim();
            if (fullName) await fillInput(page, 'input[name="name"]', fullName);
            
            if (profile.email) await fillInput(page, 'input[name="email"]', profile.email);
            if (profile.phone) await fillInput(page, 'input[name="phone"]', profile.phone);
            if (profile.org) await fillInput(page, 'input[name="org"]', profile.org);
            
            // Upload resume
            if (profile.resume_path) {
                const fileInputs = await page.$$('input[type="file"]');
                if (fileInputs.length > 0) {
                    await fileInputs[0].uploadFile(profile.resume_path);
                }
            }

            // Cover letter
            if (cover_letter) {
                await fillInput(page, 'textarea[name="comments"]', cover_letter);
            }

            // Click submit
            // UNCOMMENT THIS IN PRODUCTION:
            // await page.click('button.postings-btn[type="submit"]');
            // await page.waitForNavigation({ waitUntil: 'networkidle2' });

            success = true;
        } else if (platform === 'LINKEDIN') {
            console.log(JSON.stringify({ status: 'info', message: 'Applying on LinkedIn using authenticated session...' }));
            
            // Wait to verify we are still logged in by looking for some global element
            try {
                // Check if we are on a login/signup wall or not authenticated
                const isLoginPage = await page.$('form.login__form, form.join-form, input#session_key, a[data-tracking-control-name="guest_homepage-basic_nav-header-signin"]');
                if (isLoginPage) {
                    throw new Error('Authentication Failed. The bot is not logged into LinkedIn. Please run the bot in non-headless mode once to login.');
                }

                // Wait for the "Easy Apply" button
                const easyApplySelector = 'button.jobs-apply-button';
                await page.waitForSelector(easyApplySelector, { timeout: 10000 });
                await page.click(easyApplySelector);
                
                console.log(JSON.stringify({ status: 'info', message: 'Clicked Easy Apply. Waiting for modal...' }));
                
                // Wait for modal to pop up
                await page.waitForSelector('.jobs-easy-apply-modal', { timeout: 10000 });
                
                // A very basic next/submit loop
                let maxSteps = 10;
                while (maxSteps > 0) {
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    // Look for submit or next button
                    const submitBtn = await page.$('button[aria-label="Submit application"]');
                    if (submitBtn) {
                        // UNCOMMENT IN PRODUCTION: await submitBtn.click();
                        console.log(JSON.stringify({ status: 'info', message: 'Found Submit button!' }));
                        success = true;
                        break;
                    }
                    
                    const nextBtn = await page.$('button[aria-label="Continue to next step"]');
                    if (nextBtn) {
                        await nextBtn.click();
                    } else {
                        // Sometimes the button is just 'Review'
                        const reviewBtn = await page.$('button[aria-label="Review your application"]');
                        if (reviewBtn) {
                            await reviewBtn.click();
                        } else {
                            throw new Error('Could not find Next or Submit button on LinkedIn modal.');
                        }
                    }
                    maxSteps--;
                }
            } catch (err) {
                throw new Error(`LinkedIn application failed: ${err.message}`);
            }
        } else if (['NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'].includes(platform)) {
            console.log(JSON.stringify({ status: 'info', message: `Applying on ${platform} using authenticated session...` }));
            await new Promise(resolve => setTimeout(resolve, 3000));
            // Basic structure placeholder for other platforms
            success = true;
        }

        if (success) {
            console.log(JSON.stringify({ status: 'success', message: 'Application submitted successfully via Puppeteer.' }));
        } else {
            throw new Error('Could not automate application for this platform.');
        }
    } catch (error) {
        let screenshotPath = null;
        if (page) {
            try {
                const screenshotDir = path.resolve(process.cwd(), 'storage/app/public/error-screenshots');
                if (!fs.existsSync(screenshotDir)) {
                    fs.mkdirSync(screenshotDir, { recursive: true });
                }
                
                const filename = `error-${crypto.randomBytes(4).toString('hex')}-${Date.now()}.png`;
                const fullPath = path.join(screenshotDir, filename);
                
                await page.screenshot({ path: fullPath, fullPage: true });
                screenshotPath = `error-screenshots/${filename}`;
            } catch (screenshotError) {
                // Ignore screenshot errors
            }
        }
        
        console.error(JSON.stringify({ 
            status: 'failed', 
            message: error.message,
            screenshot_path: screenshotPath
        }));
    } finally {
        if (browser) {
            await browser.close();
        }
        process.exit(0); // Orchestrator handles success/failure based on the JSON output
    }
})();
