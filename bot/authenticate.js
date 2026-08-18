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
        const launchOptions = { 
            headless: 'new', 
            defaultViewport: null,
            env: {
                ...process.env,
                XDG_CONFIG_HOME: '/tmp',
                XDG_CACHE_HOME: '/tmp'
            }
        };
        
        if (process.env.DOCKER_ENV || inputData.is_docker) {
            launchOptions.args = [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-crash-reporter',
                '--disable-gpu',
                '--disable-software-rasterizer'
            ];
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH || '/usr/bin/chromium';
        } else if (process.env.PUPPETEER_EXECUTABLE_PATH) {
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH;
        }
        
        const browser = await puppeteer.launch(launchOptions);
        const page = await browser.newPage();
        
        // Clean cookies before injecting to prevent CDP Protocol errors
        const cleanCookies = cookies.map(cookie => {
            const { name, value, domain, path, secure, httpOnly, sameSite } = cookie;
            const validCookie = { name, value, domain, path, secure, httpOnly };
            
            if (cookie.expirationDate) validCookie.expires = cookie.expirationDate;
            else if (cookie.expires) validCookie.expires = cookie.expires;
            
            if (sameSite) {
                // Ensure SameSite is a valid CDP enum value
                const normalizedSameSite = sameSite.charAt(0).toUpperCase() + sameSite.slice(1).toLowerCase();
                if (['Strict', 'Lax', 'None'].includes(normalizedSameSite)) {
                    validCookie.sameSite = normalizedSameSite;
                }
            }
            
            return validCookie;
        });
        
        await page.setCookie(...cleanCookies);
        
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
            // Set a realistic User-Agent to avoid immediate flagging
            await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            
            await page.goto(verifyUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
            await page.waitForSelector(successSelector, { timeout: 30000 });
            console.log(JSON.stringify({ status: 'success', message: `Authentication verified for ${platform}. Session saved.` }));
        } catch (e) {
            let currentUrl = 'Unknown';
            let pageTitle = 'Unknown';
            try {
                currentUrl = await page.url();
                pageTitle = await page.title();
            } catch (e) {}

            try {
                const screenshotPath = `${session_dir}/error.png`;
                // Avoid fullPage to prevent Out-Of-Memory (OOM) crashes on 1GB instances
                await page.screenshot({ path: screenshotPath, fullPage: false });
                console.error(JSON.stringify({ status: 'failed', message: `Cookie verification failed for ${platform}. URL: ${currentUrl} | Title: ${pageTitle} | Error: ${e.message}. Screenshot saved.` }));
            } catch (screenshotError) {
                console.error(JSON.stringify({ status: 'failed', message: `Cookie verification failed for ${platform}. URL: ${currentUrl} | Title: ${pageTitle} | Error: ${e.message}. (Screenshot failed).` }));
            }
            process.exitCode = 1;
        }

        await browser.close();
        if (process.exitCode === 1) process.exit(1);
        
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: `Verification failed: ${error.message}` }));
        process.exit(1);
    }
})();
