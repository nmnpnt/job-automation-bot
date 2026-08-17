import puppeteer from 'puppeteer';

(async () => {
    console.log('Launching browser...');
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    
    page.on('console', msg => console.log('BROWSER CONSOLE:', msg.text()));
    page.on('pageerror', err => console.log('BROWSER ERROR:', err.toString()));
    
    console.log('Navigating to page...');
    await page.goto('http://127.0.0.1:8000', { waitUntil: 'networkidle0' });
    
    console.log('Waiting 5 seconds to see if Echo connects...');
    await new Promise(r => setTimeout(r, 5000));
    
    await browser.close();
})();
