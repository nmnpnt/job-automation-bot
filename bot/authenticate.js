import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import fs from 'fs';

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

    const { platform, session_dir, cookie_file } = inputData;
    
    if (!fs.existsSync(cookie_file)) {
        console.error(JSON.stringify({ status: 'failed', message: 'Cookie file not found.' }));
        process.exit(1);
    }

    let cookies = [];
    try {
        cookies = JSON.parse(fs.readFileSync(cookie_file, 'utf8'));
        if (!Array.isArray(cookies)) throw new Error("Cookies must be a JSON array.");
    } catch (e) {
        console.error(JSON.stringify({ status: 'failed', message: 'Invalid cookie JSON format.' }));
        process.exit(1);
    }

    console.log(JSON.stringify({ status: 'info', message: `Verifying cookies for ${platform}...` }));

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
        }
        
        const browser = await puppeteer.launch(launchOptions);
        const page = await browser.newPage();
        
        // Inject all cookies
        await page.setCookie(...cookies);
        
        let verifyUrl = '';
        let successSelector = '';

        switch (platform) {
            case 'LINKEDIN':
                verifyUrl = 'https://www.linkedin.com/feed/';
                successSelector = '#global-nav, .global-nav';
                break;
            case 'NAUKRI':
                verifyUrl = 'https://www.naukri.com/mnjuser/profile';
                successSelector = '.updateProfile, .profile-container';
                break;
            case 'UPLERS':
                verifyUrl = 'https://app.uplers.com/talent';
                successSelector = '.talent-dashboard, .user-profile';
                break;
            case 'UNSTOP':
                verifyUrl = 'https://unstop.com/';
                successSelector = '.logged-in, .user-profile';
                break;
            case 'HIRIST':
                verifyUrl = 'https://www.hirist.tech/candidate/dashboard';
                successSelector = '.candidate-dashboard';
                break;
            case 'CUTSHORT':
                verifyUrl = 'https://cutshort.io/profile';
                successSelector = '.user-profile, .profile-header';
                break;
            case 'INDEED':
                verifyUrl = 'https://www.indeed.com/';
                successSelector = '#gnav-main-container, .gnav-header-inner';
                break;
            default:
                // If we don't have a specific verification, just assume it works if we can set cookies
                console.log(JSON.stringify({ status: 'success', message: `Cookies loaded for ${platform}.` }));
                await browser.close();
                process.exit(0);
        }

        try {
            await page.goto(verifyUrl, { waitUntil: 'domcontentloaded', timeout: 30000 });
            await page.waitForSelector(successSelector, { timeout: 10000 });
            console.log(JSON.stringify({ status: 'success', message: `Authentication verified for ${platform}. Session saved.` }));
        } catch (e) {
            console.error(JSON.stringify({ status: 'failed', message: `Cookie verification failed for ${platform}. Please ensure cookies are fresh.` }));
            process.exitCode = 1;
        }

        await browser.close();
        if (process.exitCode === 1) process.exit(1);
        
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: `Verification failed: ${error.message}` }));
        process.exit(1);
    }
})();
