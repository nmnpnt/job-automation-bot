import puppeteer from 'puppeteer';
import path from 'path';
import fs from 'fs';

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

    const { platform, session_dir } = inputData;
    
    // Ensure session dir exists
    if (!fs.existsSync(session_dir)) {
        fs.mkdirSync(session_dir, { recursive: true });
    }

    let loginUrl = '';
    let successSelector = '';

    switch (platform) {
        case 'LINKEDIN':
            loginUrl = 'https://www.linkedin.com/login';
            successSelector = '#global-nav, .global-nav, .scaffold-layout'; // Broaden selector for logged-in state
            break;
        case 'NAUKRI':
            loginUrl = 'https://login.naukri.com/nLogin/Login.php';
            successSelector = '.nI-gNb-header__logo'; // Naukri logged in header
            break;
        case 'UPLERS':
            loginUrl = 'https://app.uplers.com/login';
            successSelector = '.sidebar-menu'; // Assuming a sidebar appears
            break;
        case 'UNSTOP':
            loginUrl = 'https://unstop.com/login';
            successSelector = '.avatar'; // User avatar
            break;
        case 'HIRIST':
            loginUrl = 'https://www.hirist.tech/login';
            successSelector = '.logged-in-user'; 
            break;
        case 'CUTSHORT':
            loginUrl = 'https://cutshort.io/login';
            successSelector = '#cs-header-user-menu';
            break;
        default:
            console.error(JSON.stringify({ status: 'failed', message: 'Unknown platform' }));
            process.exit(1);
    }

    console.log(JSON.stringify({ status: 'info', message: `Launching browser for ${platform} authentication...` }));

    try {
        // Launch visible browser
        const browser = await puppeteer.launch({ 
            headless: false,
            userDataDir: session_dir,
            defaultViewport: null,
            args: [
                '--disable-restore-session-state',
                '--no-first-run',
                '--no-default-browser-check'
            ]
        });
        
        // Use the first automatically opened tab instead of spawning a new blank one
        const pages = await browser.pages();
        const page = pages.length > 0 ? pages[0] : await browser.newPage();
        
        console.log(JSON.stringify({ status: 'info', message: `Please log in to ${platform} manually in the opened browser window.` }));
        await page.goto(loginUrl, { waitUntil: 'networkidle2' }).catch(() => {});
        
        // Wait up to 5 minutes for the user to log in manually
        // Or if the user closes the browser window manually after logging in
        await Promise.race([
            page.waitForSelector(successSelector, { timeout: 300000 }).catch(() => {}),
            new Promise(resolve => browser.on('disconnected', resolve))
        ]);
        
        console.log(JSON.stringify({ status: 'success', message: `Authentication finished for ${platform}. Session saved.` }));
        
        try {
            await browser.close();
        } catch (e) {
            // Ignore if already closed
        }
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: `Authentication timed out or failed: ${error.message}` }));
        process.exit(1);
    }
})();
