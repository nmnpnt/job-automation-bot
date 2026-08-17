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
                await page.goto(searchUrl, { waitUntil: 'domcontentloaded' });
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

        // Filter jobs to ensure they match at least one of the target roles strictly
        const matchedJobs = allJobs.filter(job => {
            const titleLower = job.title.toLowerCase();
            return roles.some(role => {
                // Escape regex special chars and add word boundaries for exact phrase matching
                const escapedRole = role.toLowerCase().replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`\\b${escapedRole}\\b`, 'i');
                return regex.test(titleLower);
            });
        });

        // Deduplicate jobs by URL
        const uniqueJobs = Array.from(new Map(matchedJobs.map(item => [item.url, item])).values());
        
        await browser.close();
        
        console.log(JSON.stringify({ status: 'success', jobs: uniqueJobs }));
        
    } catch (error) {
        console.error(JSON.stringify({ status: 'failed', message: error.message }));
        process.exit(1);
    }
})();
