const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
puppeteer.use(StealthPlugin());
const fs = require('fs');

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
    const { target_roles, target_locations, remote_only } = preferences;

    const roles = target_roles ? target_roles.split(',').map(r => r.trim()).filter(r => r) : ['Software Engineer'];
    const locations = target_locations ? target_locations.split(',').map(l => l.trim()).filter(l => l) : [];

    let searchQueries = [];
    roles.forEach(role => {
        if (locations.length > 0 && !remote_only) {
            locations.forEach(location => {
                searchQueries.push({ role, location });
            });
        } else {
            searchQueries.push({ role, location: remote_only ? 'Remote' : '' });
        }
    });

    try {
        const browser = await puppeteer.launch({ 
            headless: 'new',
            userDataDir: session_dir,
            defaultViewport: null
        });
        
        const page = await browser.newPage();
        
        let allJobs = [];

        for (const query of searchQueries) {
            // Build Search URL based on platform
            let searchUrl = '';
            let jobSelector = '';
            
            const keyword = encodeURIComponent(query.role);
            const loc = encodeURIComponent(query.location);

            switch (platform) {
                case 'LINKEDIN':
                    // LinkedIn "All Jobs" search
                    // remote filter: f_WT=2 (Remote)
                    const remoteParam = remote_only ? '&f_WT=2' : '';
                    searchUrl = `https://www.linkedin.com/jobs/search/?keywords=${keyword}&location=${loc}${remoteParam}`;
                    jobSelector = '.job-card-container';
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
                await page.goto(searchUrl, { waitUntil: 'networkidle2' });
                // Note: Real implementations would handle pagination, infinite scrolling, 
                // and wait for specific selectors. This is a simplified mock extractor.
                
                // Wait a bit for dynamic content
                await new Promise(r => setTimeout(r, 3000));
                
                const jobs = await page.evaluate((sel, plat) => {
                    const jobNodes = document.querySelectorAll(sel);
                    const extracted = [];
                    
                    jobNodes.forEach(node => {
                        let url = '', title = 'Unknown', company = 'Unknown', location = 'Unknown';
                        
                        // Rough extraction logic (these selectors would need constant updating in reality)
                        if (plat === 'LINKEDIN') {
                            const link = node.querySelector('.job-card-list__title');
                            if (link) {
                                url = link.href;
                                title = link.innerText.trim();
                            }
                            const comp = node.querySelector('.job-card-container__primary-description');
                            if (comp) company = comp.innerText.trim();
                            const loc = node.querySelector('.job-card-container__metadata-item');
                            if (loc) location = loc.innerText.trim();
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
                    
                    return extracted;
                }, jobSelector, platform);

                allJobs.push(...jobs);

            } catch (err) {
                console.error(`Error searching ${query.role}: ${err.message}`);
            }
        }

        // Deduplicate jobs by URL
        const uniqueJobs = Array.from(new Map(allJobs.map(item => [item.url, item])).values());
        
        await browser.close();
        
        console.log(JSON.stringify({ status: 'success', jobs: uniqueJobs }));
        
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: error.message }));
        process.exit(1);
    }
})();
