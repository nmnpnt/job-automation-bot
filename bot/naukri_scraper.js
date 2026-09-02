import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import fs from 'fs';
import path from 'path';
import os from 'os';

// Ported from the original Node/Puppeteer scraper that was confirmed working
// against Naukri. This version is trimmed to ONLY handle Naukri, since
// CUTSHORT/HIRIST/UNSTOP/LINKEDIN/INDEED already work fine via the Python
// httpx/Playwright paths in fetch_jobs.py.
//
// Key difference vs. the curl_cffi approach it replaces: this script never
// calls the gated /jobapi/v3/search endpoint directly. It navigates straight
// to the rendered search-results page (e.g. https://www.naukri.com/software-
// engineer-jobs-in-bangalore) and lets Naukri's own front-end JS populate the
// DOM from inside a real, stealth-passing browser session (real cookies,
// referrer, JS environment). That's a different request fingerprint than a
// bare API GET, which is why it isn't hitting the same reCAPTCHA wall.
//
// NOTE ON SELECTORS: `.srp-jobtuple-wrapper` and its children reflect Naukri's
// commonly-documented markup as of when this was last known to work. Naukri
// changes its DOM periodically without notice — if node/job counts come back
// as 0, view the debug screenshot this script saves and update the selectors
// below to match what's actually on the page.

process.on('uncaughtException', (err) => {
    if (err.message && err.message.includes('Requesting main frame too early')) {
        // Known stealth-plugin quirk on Puppeteer 23+, safe to ignore.
        return;
    }
    console.error(`Uncaught Exception: ${err.message}`);
});

process.on('unhandledRejection', (reason) => {
    if (reason && reason.message && reason.message.includes('Requesting main frame too early')) {
        return;
    }
});

puppeteer.use(StealthPlugin());

function slugify(text) {
    return encodeURIComponent(text).replace(/%20/g, '-');
}

(async () => {
    let browser;
    process.on('SIGTERM', async () => {
        console.error(`[${new Date().toISOString()}] Received SIGTERM. Shutting down browser...`);
        if (browser) await browser.close();
        process.exit(0);
    });

    const args = process.argv.slice(2);
    if (args.length === 0) {
        console.log(JSON.stringify({ status: 'failed', message: 'No input provided' }));
        process.exit(1);
    }

    let inputData;
    try {
        inputData = JSON.parse(args[0]);
    } catch (e) {
        console.log(JSON.stringify({ status: 'failed', message: 'Invalid JSON input' }));
        process.exit(1);
    }

    const { session_dir, preferences = {} } = inputData;
    const {
        target_roles,
        target_locations,
        remote_preference,
        max_job_age_days,
    } = preferences;

    const roles = target_roles
        ? target_roles.split(',').map(r => r.trim()).filter(Boolean)
        : ['Software Engineer'];
    const locations = target_locations
        ? target_locations.split(',').map(l => l.trim()).filter(Boolean)
        : [];

    let searchQueries = [];
    roles.forEach(role => {
        if (remote_preference === 'only') {
            searchQueries.push({ role, location: 'Remote' });
        } else {
            if (locations.length > 0) {
                locations.forEach(location => searchQueries.push({ role, location }));
            } else if (remote_preference === 'none') {
                searchQueries.push({ role, location: '' });
            }
            if (remote_preference === 'include') {
                searchQueries.push({ role, location: 'Remote' });
            }
        }
    });

    const pagedSearchQueries = [];
    searchQueries.forEach(query => {
        for (let page = 1; page <= 5; page++) {
            pagedSearchQueries.push({ ...query, page });
        }
    });
    searchQueries = pagedSearchQueries;

    let allJobs = [];

    try {
        const launchOptions = {
            headless: 'new',
            defaultViewport: null,
            env: {
                ...process.env,
                XDG_CONFIG_HOME: os.tmpdir(),
                XDG_CACHE_HOME: os.tmpdir(),
            },
        };

        if (process.env.DOCKER_ENV || inputData.is_docker) {
            launchOptions.args = [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-crash-reporter',
                '--disable-gpu',
                '--disable-software-rasterizer',
            ];
            launchOptions.userDataDir = '/tmp/puppeteer_data_naukri';
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH || '/usr/bin/chromium';
        }

        if (process.env.PUPPETEER_EXECUTABLE_PATH) {
            launchOptions.executablePath = process.env.PUPPETEER_EXECUTABLE_PATH;
        } else {
            const possiblePaths = [
                'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
                'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
                '/usr/bin/chromium',
                '/usr/bin/chromium-browser',
                '/usr/bin/google-chrome',
            ];
            for (const p of possiblePaths) {
                if (fs.existsSync(p)) {
                    launchOptions.executablePath = p;
                    break;
                }
            }
        }

        console.error(`[${new Date().toISOString()}] Launching browser for Naukri...`);
        browser = await puppeteer.launch(launchOptions);
        console.error(`[${new Date().toISOString()}] Browser launched successfully.`);

        for (const query of searchQueries) {
            console.error(`[${new Date().toISOString()}] Naukri query: role="${query.role}", location="${query.location}"`);
            let page;
            try {
                page = await browser.newPage();
                await page.setUserAgent(
                    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                );

                if (session_dir) {
                    const cookieFile = path.join(session_dir, 'cookies.json');
                    if (fs.existsSync(cookieFile)) {
                        try {
                            const cookies = JSON.parse(
                                fs.readFileSync(cookieFile, 'utf8').replace(/^\uFEFF/, '')
                            );
                            const cleanCookies = cookies.map(cookie => {
                                const { name, value, domain, path: p, secure, httpOnly, sameSite } = cookie;
                                const valid = { name, value, domain, path: p, secure, httpOnly };
                                if (cookie.expirationDate) valid.expires = cookie.expirationDate;
                                else if (cookie.expires) valid.expires = cookie.expires;
                                if (sameSite) {
                                    const normalized = sameSite.charAt(0).toUpperCase() + sameSite.slice(1).toLowerCase();
                                    if (['Strict', 'Lax', 'None'].includes(normalized)) valid.sameSite = normalized;
                                }
                                return valid;
                            });
                            await page.setCookie(...cleanCookies);
                            console.error(`[DEBUG] Naukri cookies loaded: ${cleanCookies.length}`);
                        } catch (e) {
                            console.error(`[ERROR] Naukri cookie load failed: file="${cookieFile}", ${e.name}: ${e.message}`);
                        }
                    }
                }
            } catch (e) {
                console.error(`[DEBUG] Error preparing page for "${query.role}": ${e.message}`);
                continue;
            }

            const keywordSlug = slugify(query.role);
            let searchUrl;
            if (query.location && query.location.toLowerCase() !== 'remote' && query.location !== '') {
                searchUrl = `https://www.naukri.com/${keywordSlug}-jobs-in-${slugify(query.location)}`;
            } else {
                searchUrl = `https://www.naukri.com/${keywordSlug}-jobs`;
            }
            if (['1', '7', '14', '30'].includes(String(max_job_age_days))) {
                searchUrl += `?jobAge=${max_job_age_days}`;
            }
            if (query.page > 1) {
                searchUrl += `${searchUrl.includes('?') ? '&' : '?'}page=${query.page}`;
            }

            try {
                console.error(`[DEBUG] Loading ${searchUrl}`);
                await page.goto(searchUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
                await new Promise(r => setTimeout(r, 3000));

                for (let i = 0; i < 3; i++) {
                    try {
                        await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
                    } catch (e) {}
                    await new Promise(r => setTimeout(r, 2000));
                }

                let jobs = { extracted: [], nodeCount: 0, pageTitle: 'Failed' };
                try {
                    jobs = await page.evaluate(() => {
                        // Multiple fallback selectors since Naukri's markup changes
                        // periodically. Update these if nodeCount comes back 0.
                        const wrapperSel = '.srp-jobtuple-wrapper, article.jobTuple, .jobTuple';
                        const jobNodes = document.querySelectorAll(wrapperSel);
                        const extracted = [];

                        jobNodes.forEach(node => {
                            let url = '', title = '', company = '', location = '';

                            const titleLink = node.querySelector('a.title, .title a, a[href*="/job-listings-"]');
                            if (titleLink) {
                                url = titleLink.href;
                                title = titleLink.innerText.trim() || titleLink.getAttribute('title') || '';
                            }

                            const compNode = node.querySelector('a.comp-name, .comp-name, .companyInfo a, span.comp-name');
                            if (compNode) company = compNode.innerText.trim();

                            const locNode = node.querySelector('.locWdth, .loc-wdth, span.locWdth, [class*="loc"]');
                            if (locNode) location = locNode.innerText.trim();

                            if (url) {
                                try {
                                    const parsed = new URL(url);
                                    url = parsed.origin + parsed.pathname;
                                } catch (e) {}
                                extracted.push({ url, title: title || 'Unknown', company: company || 'Unknown', location: location || 'Unknown' });
                            }
                        });

                        return { extracted, nodeCount: jobNodes.length, pageTitle: document.title };
                    });
                } catch (e) {
                    console.error(`[DEBUG] Failed to evaluate jobs: ${e.message}`);
                }

                console.error(`[DEBUG] Page title: ${jobs.pageTitle}, URL: ${page.url()}, Nodes found: ${jobs.nodeCount}, Jobs extracted: ${jobs.extracted.length}`);

                if (jobs.nodeCount === 0 && session_dir) {
                    try {
                        await page.screenshot({ path: path.join(session_dir, `naukri_empty_${Date.now()}.png`), fullPage: false });
                        console.error(`[DEBUG] Saved empty-result screenshot to session_dir`);
                    } catch (e) {}
                }
                if (jobs.nodeCount === 0) {
                    const bodyPreview = await page.evaluate(() => document.body?.innerText?.slice(0, 300) || '');
                    console.error(`[ERROR] Naukri returned zero job-card nodes: finalUrl="${page.url()}", title="${jobs.pageTitle}", bodyPreview="${bodyPreview.replace(/\s+/g, ' ')}"`);
                } else if (jobs.extracted.length === 0) {
                    console.error(`[ERROR] Naukri found ${jobs.nodeCount} card nodes but extracted zero jobs; selectors or card links may have changed.`);
                }

                jobs.extracted.forEach(j => { j.query_keyword = query.role; });
                allJobs.push(...jobs.extracted);
            } catch (err) {
                console.error(`[DEBUG] Error searching "${query.role}": ${err.message}`);
                if (session_dir) {
                    try {
                        await page.screenshot({ path: path.join(session_dir, `naukri_failure_${Date.now()}.png`), fullPage: true });
                    } catch (e) {}
                }
            }

            try {
                if (page) await page.close();
            } catch (e) {}
        }

        const uniqueJobs = Array.from(new Map(allJobs.map(item => [item.url, item])).values());

        console.error(`[${new Date().toISOString()}] Fetching descriptions for ${uniqueJobs.length} Naukri jobs...`);
        const BATCH_SIZE = 3;
        for (let i = 0; i < uniqueJobs.length; i += BATCH_SIZE) {
            const batch = uniqueJobs.slice(i, i + BATCH_SIZE);
            await Promise.all(batch.map(async (job) => {
                let detailPage;
                try {
                    detailPage = await browser.newPage();
                    await detailPage.setUserAgent(
                        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                    );
                    await detailPage.goto(job.url, { waitUntil: 'domcontentloaded', timeout: 30000 });
                    await new Promise(r => setTimeout(r, 2000));

                    const description = await detailPage.evaluate(() => {
                        const formatNodeText = (node) => {
                            if (!node) return '';
                            node.querySelectorAll('li').forEach(li => {
                                const text = li.innerText.trim();
                                if (text && !text.startsWith('•') && !text.startsWith('-')) {
                                    li.innerText = '• ' + li.innerText;
                                }
                            });
                            return node.innerText.trim();
                        };

                        const selectors = [
                            '.job-desc', 'section.job-desc', '.dang-inner-html',
                            '[class*="styles_JDC__"]', '[class*="JobDescription"]',
                            '.job-detail-content', '.styles_job-desc-container',
                        ];
                        for (const sel of selectors) {
                            const node = document.querySelector(sel);
                            if (node && node.innerText.length > 100) return formatNodeText(node);
                        }
                        const bodyText = document.body.innerText.trim();
                        return bodyText.length > 200 ? bodyText.substring(0, 5000) : '';
                    });

                    job.description = description;
                    job.skills = '';
                } catch (e) {
                    console.error(`[DEBUG] Failed to fetch description for ${job.url}: ${e.message}`);
                } finally {
                    if (detailPage) {
                        try { await detailPage.close(); } catch (e) {}
                    }
                }
            }));
            await new Promise(r => setTimeout(r, 2000));
        }

        await browser.close();
        console.log(JSON.stringify({ status: 'success', jobs: uniqueJobs }));
    } catch (error) {
        if (browser) {
            try { await browser.close(); } catch (e) {}
        }
        console.log(JSON.stringify({ status: 'failed', message: error.message }));
        process.exit(1);
    }
})();
