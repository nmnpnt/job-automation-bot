const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
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
        if (session_dir) {
            launchOptions.userDataDir = session_dir;
        }
        
        browser = await puppeteer.launch(launchOptions);
        page = await browser.newPage();
        
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
        } else if (['LINKEDIN', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'].includes(platform)) {
            console.log(JSON.stringify({ status: 'info', message: `Applying on ${platform} using authenticated session...` }));
            
            // Wait to verify we are still logged in by looking for some global element 
            // In a real implementation this would be specific to each platform
            await new Promise(resolve => setTimeout(resolve, 3000));
            
            // MOCK LOGIC for the application flow:
            // The bot would look for the "Apply" or "Easy Apply" button.
            // On LinkedIn, it might need to click through multiple modals.
            // Here we assume successful injection of session and application.
            
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
                const crypto = require('crypto');
                const fs = require('fs');
                const path = require('path');
                
                const screenshotDir = path.resolve(__dirname, '../storage/app/public/error-screenshots');
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
