import sys
import json
import asyncio
import os
import time
import re
from urllib.parse import urlparse
from playwright.async_api import async_playwright

try:
    from curl_cffi import requests as cffi_requests
    _CURL_CFFI_AVAILABLE = True
except ImportError:
    _CURL_CFFI_AVAILABLE = False

async def run_scraper(input_data):
    platform = input_data.get('platform')
    session_dir = input_data.get('session_dir')
    preferences = input_data.get('preferences', {})
    
    target_roles = preferences.get('target_roles') or 'Software Engineer'
    target_locations = preferences.get('target_locations') or ''
    remote_preference = preferences.get('remote_preference') or 'none'
    max_job_age_days = preferences.get('max_job_age_days') or 30

    roles = [r.strip() for r in target_roles.split(',') if r.strip()]
    locations = [l.strip() for l in target_locations.split(',') if l.strip()]
    
    search_queries = []
    for role in roles:
        if remote_preference == 'only':
            search_queries.append({'role': role, 'location': 'Remote'})
        else:
            if locations:
                for loc in locations:
                    search_queries.append({'role': role, 'location': loc})
            elif remote_preference == 'none':
                search_queries.append({'role': role, 'location': ''})
            
            if remote_preference == 'include':
                search_queries.append({'role': role, 'location': 'Remote'})

    all_jobs = []

    if platform in ['UNSTOP', 'CUTSHORT', 'HIRIST']:
        import httpx
        from bs4 import BeautifulSoup
        async with httpx.AsyncClient(timeout=15.0) as client:
            for query in search_queries:
                keyword = query['role']
                loc = query['location']
                try:
                    if platform == 'UNSTOP':
                        url = f"https://unstop.com/api/public/opportunity/search-result?opportunity=jobs&page=1&per_page=15&searchTerm={keyword}"
                        res = await client.get(url, headers={"User-Agent": "Mozilla/5.0"})
                        if res.status_code == 200:
                            data = res.json()
                            jobs_data = data.get('data', {}).get('data', [])
                            for j in jobs_data:
                                title = j.get('title', '')
                                company = j.get('organisation', {}).get('name', '')
                                job_url = j.get('seo_url', '')
                                desc = j.get('details', '')
                                location = 'Remote' if j.get('region') == 'online' else (j.get('job_location', '') or '')
                                if title and job_url:
                                    all_jobs.append({'title': title, 'company': company, 'location': location, 'url': job_url, 'description': desc, 'query_keyword': keyword})
                    elif platform == 'CUTSHORT':
                        url = f"https://cutshort.io/jobs?q={keyword}"
                        res = await client.get(url, headers={"User-Agent": "Mozilla/5.0"})
                        if res.status_code == 200:
                            soup = BeautifulSoup(res.text, 'html.parser')
                            script = soup.find('script', id='__NEXT_DATA__')
                            if script:
                                data = json.loads(script.string)
                                queries = data.get('props', {}).get('pageProps', {}).get('dehydratedState', {}).get('queries', [])
                                for q in queries:
                                    jobs_list = q.get('state', {}).get('data', {}).get('data', {}).get('pageData', {}).get('jobs', [])
                                    if jobs_list:
                                        for j in jobs_list:
                                            title = j.get('headline', '')
                                            company = j.get('companyDetails', {}).get('name', '')
                                            job_url = j.get('publicUrl', '')
                                            if job_url and not job_url.startswith('http'):
                                                job_url = 'https://cutshort.io' + job_url
                                            desc = j.get('sanitizedComment', '')
                                            location = j.get('locationsText', '')
                                            if title and job_url:
                                                all_jobs.append({'title': title, 'company': company, 'location': location, 'url': job_url, 'description': desc, 'query_keyword': keyword})
                    elif platform == 'HIRIST':
                        url = f"https://gladiator.hirist.tech/job/search?query={keyword}&page=0&posting=0&industry=&size=20"
                        res = await client.get(url, headers={"User-Agent": "Mozilla/5.0", "Accept": "application/json"})
                        if res.status_code == 200:
                            data = res.json()
                            jobs_list = data.get('data', [])
                            for j in jobs_list:
                                title = j.get('title', '')
                                company = j.get('companyName', '')
                                location = j.get('location', '')
                                if isinstance(location, list):
                                    location = ', '.join([loc.get('name', '') if isinstance(loc, dict) else str(loc) for loc in location])
                                job_url = j.get('jobDetailUrl', '')
                                desc = ''
                                if title:
                                    all_jobs.append({'title': title, 'company': company, 'location': location, 'url': job_url, 'description': desc, 'query_keyword': keyword})
                except Exception as e:
                    print(f"[DEBUG] Failed HTTP fetch for {platform}: {e}", file=sys.stderr)
    elif platform == 'NAUKRI':
        # Naukri uses Akamai deep TLS fingerprinting — curl_cffi impersonates a real
        # Chrome TLS stack to bypass it. Even with valid auth cookies, the job search
        # API (/jobapi/v3/search) returns HTTP 406 "recaptcha required". The SSR HTML
        # shell also returns loading:true / jobDetails:[] in the RSC preloadState.
        # We still attempt RSC parsing in case a future version includes pre-rendered jobs.
        if not _CURL_CFFI_AVAILABLE:
            print("[DEBUG] Naukri requires curl_cffi. Install: pip install curl_cffi", file=sys.stderr)
        else:
            from bs4 import BeautifulSoup as _BS
            raw_cookies = {}
            cookie_file = os.path.normpath(os.path.join(session_dir, 'cookies.json')) if session_dir else None
            if cookie_file and os.path.exists(cookie_file):
                try:
                    with open(cookie_file, 'r', encoding='utf-8-sig') as f:
                        raw_list = json.load(f)
                    raw_cookies = {c['name']: c['value'] for c in raw_list}
                except Exception as e:
                    print(f"[DEBUG] Naukri cookie load error: {e}", file=sys.stderr)

            naukri_headers = {
                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language': 'en-IN,en;q=0.9',
                'Referer': 'https://www.naukri.com/',
            }

            for query in search_queries:
                keyword = query['role']
                loc = query['location']
                kw_slug = keyword.lower().replace(' ', '-')
                if loc and loc.lower() not in ['remote', 'india', '']:
                    naukri_url = f"https://www.naukri.com/{kw_slug}-jobs-in-{loc.lower().replace(' ', '-')}"
                else:
                    naukri_url = f"https://www.naukri.com/{kw_slug}-jobs"
                if str(max_job_age_days) in ['1', '7', '14', '30']:
                    naukri_url += f"?jobAge={max_job_age_days}"

                print(f"[DEBUG] Naukri (curl_cffi): {naukri_url}", file=sys.stderr)
                try:
                    resp = cffi_requests.get(
                        naukri_url,
                        headers=naukri_headers,
                        cookies=raw_cookies,
                        impersonate='chrome120',
                        timeout=20,
                    )
                    if resp.status_code == 200:
                        # Parse Next.js RSC streaming chunks for job data
                        rsc_chunks = re.findall(
                            r'self\.__next_f\.push\(\[1,"(.*?)"\]\)',
                            resp.text, re.DOTALL
                        )
                        jobs_found = 0
                        for chunk in rsc_chunks:
                            try:
                                decoded = chunk.replace('\\"', '"').replace('\\\\', '\\').replace('\\/', '/')
                            except Exception:
                                continue
                            m = re.search(
                                r'"jobDetails"\s*:\s*(\[.+?\])\s*,\s*"(?:fatFooter|filters|failover)"',
                                decoded, re.DOTALL
                            )
                            if m:
                                try:
                                    jobs_list = json.loads(m.group(1))
                                    for j in jobs_list:
                                        title = j.get('title', j.get('jobTitle', ''))
                                        company = j.get('companyName', '')
                                        placeholders = j.get('placeholders', [])
                                        loc_label = placeholders[1].get('label', '') if len(placeholders) > 1 else ''
                                        job_url = j.get('jdURL', j.get('jobURL', ''))
                                        if job_url and not job_url.startswith('http'):
                                            job_url = 'https://www.naukri.com' + job_url
                                        if title and job_url:
                                            all_jobs.append({
                                                'title': title, 'company': company,
                                                'location': loc_label, 'url': job_url,
                                                'description': '', 'query_keyword': keyword,
                                            })
                                            jobs_found += 1
                                except Exception as je:
                                    print(f"[DEBUG] Naukri RSC parse error: {je}", file=sys.stderr)
                        if jobs_found == 0:
                            print(
                                "[DEBUG] Naukri: 0 jobs from SSR (preloadState has loading:true). "
                                "API /jobapi/v3/search requires reCAPTCHA (HTTP 406) even with "
                                "valid auth cookies — not automatable without a CAPTCHA solver.",
                                file=sys.stderr,
                            )
                    else:
                        print(f"[DEBUG] Naukri HTTP {resp.status_code} for {naukri_url}", file=sys.stderr)
                except Exception as e:
                    print(f"[DEBUG] Naukri curl_cffi error: {e}", file=sys.stderr)
    else:
        # Use manual start/stop (NOT async with) so browser/context stays alive
        # through BOTH the scraping phase AND the description-fetching phase below.
        p = await async_playwright().start()
        browser = await p.chromium.launch(
            headless=True,
            args=[
                '--headless=new',
                '--disable-blink-features=AutomationControlled',
                '--no-sandbox',
                '--disable-dev-shm-usage',
            ]
        )

        context = await browser.new_context(
            user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        )

        cookie_file = os.path.normpath(os.path.join(session_dir, 'cookies.json')) if session_dir else None
        if cookie_file and os.path.exists(cookie_file):
            try:
                with open(cookie_file, 'r', encoding='utf-8-sig') as f:
                    cookies = json.load(f)

                clean_cookies = []
                for c in cookies:
                    valid_c = {'name': c['name'], 'value': c['value'], 'domain': c['domain'], 'path': c['path']}
                    if 'expirationDate' in c:
                        valid_c['expires'] = c['expirationDate']
                    if 'secure' in c:
                        valid_c['secure'] = c['secure']
                    if 'httpOnly' in c:
                        valid_c['httpOnly'] = c['httpOnly']
                    clean_cookies.append(valid_c)

                await context.add_cookies(clean_cookies)
            except Exception as e:
                print(f"[DEBUG] Failed to load cookies: {e}", file=sys.stderr)

        for query in search_queries:
            page = await context.new_page()

            try:
                from playwright_stealth import stealth_async
                await stealth_async(page)
            except ImportError:
                pass

            keyword = query['role']
            loc = query['location']

            search_url = ''
            job_selector = ''

            if platform == 'INDEED':
                # Use Indian subdomain so geo-targeting returns Indian jobs (www.indeed.com returns US results)
                search_url = f"https://in.indeed.com/jobs?q={keyword}&l={loc}"
                job_selector = '.job_seen_beacon'
            elif platform == 'LINKEDIN':
                time_filter = ''
                if str(max_job_age_days) == '1':
                    time_filter = '&f_TPR=r86400'
                elif str(max_job_age_days) == '7':
                    time_filter = '&f_TPR=r604800'
                elif str(max_job_age_days) == '30':
                    time_filter = '&f_TPR=r2592000'

                remote_param = '&f_WT=2' if remote_preference == 'only' or loc == 'Remote' else ''
                search_url = f"https://www.linkedin.com/jobs/search/?keywords={keyword}&location={loc}{remote_param}{time_filter}"
                job_selector = '.job-search-card, .base-card'
            elif platform == 'UPLERS':
                # Uplers talent portal requires authentication.
                # If cookies are provided for platform.uplers.com, use them.
                search_url = 'https://platform.uplers.com/talent/jobs'
                job_selector = '[class*="job-card"], [class*="jobCard"], [class*="JobCard"], [class*="opportunity"], [class*="Opportunity"]'
            else:
                raise Exception('Unknown platform')

            try:
                print(f"[DEBUG] Loading {search_url}", file=sys.stderr)
                await page.goto(search_url, wait_until='domcontentloaded', timeout=60000)
                # Uplers is a heavy SPA that needs extra time to render job cards
                await page.wait_for_timeout(6000 if platform == 'UPLERS' else 3000)

                for _ in range(3):
                    await page.evaluate('window.scrollTo(0, document.body.scrollHeight)')
                    await page.wait_for_timeout(2000)

                jobs = await page.evaluate('''([sel, plat]) => {
                    const jobNodes = document.querySelectorAll(sel);
                    const extracted = [];

                    jobNodes.forEach(node => {
                        let url = '', title = 'Unknown', company = 'Unknown', location = 'Unknown';

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
                            // Try multiple Indeed selectors — DOM varies by region/experiment
                            const link = node.querySelector('h2.jobTitle a, h2 a[data-jk], a[id^="job_"], a.jcs-JobTitle');
                            if (link) {
                                // Resolve href relative to current page in case it's a relative URL
                                try { url = new URL(link.getAttribute('href') || '', window.location.href).href; } catch(e) { url = link.href || ''; }
                                const span = link.querySelector('span[title], span:not([class*="visually"])');
                                title = (span ? span.innerText : link.innerText).trim() || 'Unknown';
                            }
                            // Fallback: use data-jk to build canonical URL
                            if (!url) {
                                const jk = node.getAttribute('data-jk') || node.querySelector('[data-jk]')?.getAttribute('data-jk');
                                if (jk) url = `https://www.indeed.com/viewjob?jk=${jk}`;
                            }
                            const comp = node.querySelector('[data-testid="company-name"], .companyName');
                            if (comp) company = comp.innerText.trim();
                            const locationNode = node.querySelector('[data-testid="text-location"], .companyLocation');
                            if (locationNode) location = locationNode.innerText.trim();
                        } else if (plat === 'NAUKRI') {
                            const link = node.querySelector('a.title');
                            if (link) {
                                url = link.href;
                                title = link.innerText.trim();
                            }
                            const comp = node.querySelector('a.comp-name');
                            if (comp) company = comp.innerText.trim();
                            const loc = node.querySelector('.locWdth, .loc-wrap');
                            if (loc) location = loc.innerText.trim();
                        } else if (plat === 'UPLERS') {
                            // platform.uplers.com/talent/jobs — React SPA, try broad selectors
                            const titleEl = node.querySelector(
                                'h2, h3, h4, [class*="title" i], [class*="name" i], [data-testid*="title"]'
                            );
                            if (titleEl) title = titleEl.innerText.trim();

                            // Job URL: look for links, or build from job ID attribute
                            const linkEl = node.querySelector('a[href*="/job"], a[href*="opportunity"], a');
                            if (linkEl) {
                                url = linkEl.href;
                            } else {
                                // Fallback: try data-id or data-job-id on the card itself
                                const jid = node.getAttribute('data-id') ||
                                            node.getAttribute('data-job-id') ||
                                            node.querySelector('[data-id], [data-job-id]')?.getAttribute('data-id');
                                if (jid) url = 'https://platform.uplers.com/talent/jobs/' + jid;
                            }

                            const compEl = node.querySelector(
                                '[class*="company" i], [class*="client" i], [class*="employer" i]'
                            );
                            if (compEl) company = compEl.innerText.trim();

                            const locEl = node.querySelector(
                                '[class*="location" i], [class*="place" i], [class*="region" i]'
                            );
                            if (locEl) location = locEl.innerText.trim();
                        } else {
                            const link = node.querySelector('a');
                            url = link ? link.href : window.location.href;
                            title = node.innerText.split('\\n')[0];
                        }

                        if (url) {
                            // Keep full URL for Indeed (query params needed); strip for others
                            if (plat !== 'INDEED') {
                                try {
                                    const parsedUrl = new URL(url);
                                    url = parsedUrl.origin + parsedUrl.pathname;
                                } catch (e) {}
                            }
                            extracted.push({ url, title, company, location });
                        }
                    });
                    return { extracted, nodeCount: jobNodes.length, pageTitle: document.title };
                }''', [job_selector, platform])

                print(f"[DEBUG] Page title: {jobs['pageTitle']}, Nodes found: {jobs['nodeCount']}", file=sys.stderr)

                for j in jobs['extracted']:
                    j['query_keyword'] = keyword
                all_jobs.extend(jobs['extracted'])

            except Exception as e:
                print(f"[DEBUG] Error on {query['role']}: {str(e)}", file=sys.stderr)
                if session_dir:
                    try:
                        await page.screenshot(path=os.path.join(session_dir, f'failure_{platform}_{int(time.time())}.png'))
                    except:
                        pass
            finally:
                await page.close()
        # Playwright scraping loop ends here


    unique_jobs = list({job['url']: job for job in all_jobs}.values())
    print(f"[DEBUG] Found {len(unique_jobs)} unique jobs. Fetching descriptions...", file=sys.stderr)

    # Increase batch size for much faster concurrency now that we block heavy assets
    BATCH_SIZE = 3
    import httpx
    from bs4 import BeautifulSoup

    async with httpx.AsyncClient(timeout=15.0) as http_client:
        for i in range(0, len(unique_jobs), BATCH_SIZE):
            batch = unique_jobs[i:i + BATCH_SIZE]
            print(f"[DEBUG] Processing description batch {i//BATCH_SIZE + 1}/{(len(unique_jobs) + BATCH_SIZE - 1)//BATCH_SIZE}", file=sys.stderr)
        
            async def process_job(job):
                if job.get('description'):
                    return
                    
                target_url = job['url']
                is_linkedin = False
            
                if 'linkedin.com/jobs' in target_url:
                    import re
                    view_match = re.search(r'view/(\d+)', target_url)
                    id_match = re.search(r'currentJobId=(\d+)', target_url)
                    job_id = view_match.group(1) if view_match else (id_match.group(1) if id_match else None)
                    if job_id:
                        target_url = f"https://www.linkedin.com/jobs-guest/jobs/api/jobPosting/{job_id}"
                        is_linkedin = True
                        
                is_hirist = False
                if 'hirist.tech/j/' in target_url:
                    job_id = target_url.split('-')[-1]
                    target_url = f"https://gladiator.hirist.tech/job/detail?jobcode={job_id}"
                    is_hirist = True
            
                if is_linkedin or is_hirist:
                    try:
                        # Use httpx to bypass Playwright completely for lightning speed
                        response = await http_client.get(target_url, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'})
                        if response.status_code == 200:
                            if is_hirist:
                                data = response.json()
                                html_desc = data.get('data', {}).get('introText', '')
                                soup = BeautifulSoup(html_desc, 'html.parser')
                            else:
                                soup = BeautifulSoup(response.text, 'html.parser')
                        
                            # Convert list items to have bullets
                            for li in soup.find_all('li'):
                                text = li.get_text(strip=True)
                                if text and not text.startswith('•') and not text.startswith('-'):
                                    li.string = '• ' + text
                        
                            if is_hirist:
                                job['description'] = soup.get_text(separator='\\n', strip=True)
                            else:
                                desc_node = soup.select_one('.jobs-description-content__text, .show-more-less-html__markup, .description__text')
                                if desc_node:
                                    job['description'] = desc_node.get_text(separator='\\n', strip=True)
                                else:
                                    job['description'] = soup.get_text(separator='\\n', strip=True)
                            job['skills'] = ''
                            return
                    except Exception as e:
                        print(f"[DEBUG] Failed to fetch desc via HTTP for {job['url']}: {e}", file=sys.stderr)
                        
                if platform in ['UNSTOP', 'CUTSHORT', 'HIRIST', 'LINKEDIN']:
                    return

                # Fallback to Playwright for non-LinkedIn or if HTTP failed
                detail_page = None
                try:
                    detail_page = await context.new_page()
                
                    # Massively speed up page load by completely blocking images, CSS, fonts, and media
                    await detail_page.route("**/*", lambda route: route.abort() if route.request.resource_type in ["image", "stylesheet", "font", "media", "other"] else route.continue_())
                
                    # Reduce timeout from 30s to 15s to be faster, handle timeouts gracefully
                    await detail_page.goto(target_url, wait_until='domcontentloaded', timeout=15000)
                
                    await detail_page.wait_for_timeout(1000)
                
                    details = await detail_page.evaluate('''([plat, url]) => {
                        let description = '';
                    
                        const formatNodeText = (node) => {
                            if (!node) return '';
                            const listItems = node.querySelectorAll('li');
                            listItems.forEach(li => {
                                const text = li.innerText.trim();
                                if (text && !text.startsWith('•') && !text.startsWith('-')) {
                                    li.innerText = '• ' + li.innerText;
                                }
                            });
                            return node.innerText.trim();
                        };
                    
                        if (plat === 'INDEED') {
                            const descNode = document.querySelector('#jobDescriptionText');
                            if (descNode) description = formatNodeText(descNode);
                        } else {
                            const specificSelectors = [
                                '.job-desc', 'section.job-desc', '.dang-inner-html', 
                                '[class*="styles_job-desc-container__"]', '[class*="JobDescription"]', 
                                '.job-detail-content', '.job-details-wrapper', '#content', 
                                '.job__description', '[data-automation-id="jobPostingDescription"]'
                            ];
                            for (const selector of specificSelectors) {
                                const node = document.querySelector(selector);
                                if (node && node.innerText.length > 100) {
                                    description = formatNodeText(node);
                                    break;
                                }
                            }
                            if (!description) {
                                const bodyText = document.body.innerText.trim();
                                if (bodyText.length > 200) description = bodyText.substring(0, 5000); 
                            }
                        }
                        return { description, skills: '' };
                    }''', [platform, target_url])
                
                    job['description'] = details['description']
                    job['skills'] = details['skills']
                except Exception as e:
                    err_msg = str(e)
                    if "Target page, context or browser has been closed" in err_msg:
                        print("[DEBUG] Browser closed abruptly. Skipping desc.", file=sys.stderr)
                        # Do not re-raise, so we can at least return the jobs we found
                        return
                    print(f"[DEBUG] Failed to fetch desc for {job['url']}: {err_msg}", file=sys.stderr)
                finally:
                    if detail_page and not detail_page.is_closed():
                        try:
                            await detail_page.close()
                        except:
                            pass
        
            await asyncio.gather(*(process_job(job) for job in batch))
            await asyncio.sleep(2)
    
    # Clean up browser if Playwright was used
    if 'browser' in locals() and browser:
        try:
            await browser.close()
        except:
            pass
    if 'p' in locals() and hasattr(p, 'stop'):
        try:
            await p.stop()
        except:
            pass
    
    # Strict keyword filtering to fix fuzzy search issues
    final_jobs = []
    # Indian curated platforms have their own relevance — skip keyword filtering
    is_indian_platform = platform in ['UNSTOP', 'CUTSHORT', 'HIRIST']
    common_words = {'developer', 'engineer', 'senior', 'junior', 'lead', 'manager', 'architect', 'expert', 'specialist', 'executive'}
    
    for job in unique_jobs:
        keyword = job.get('query_keyword', '')
        keyword_lower = keyword.lower()
        core_keywords = [w for w in keyword_lower.split() if w not in common_words]
    
        title_lower = job.get('title', '').lower()
        desc_lower = job.get('description', '').lower()
    
        if not core_keywords:
            final_jobs.append(job)
            continue
        
        # Exclude recruiter/HR jobs unless the user is specifically looking for them
        negative_keywords = ['recruiter', 'talent acquisition', 'staffing', 'human resources']
        is_recruiter_job = any(neg in title_lower for neg in negative_keywords) or title_lower.startswith('hr ') or ' hr ' in title_lower
        user_wants_recruiter = any(neg in keyword_lower for neg in negative_keywords) or keyword_lower.startswith('hr ') or ' hr ' in keyword_lower
    
        if is_recruiter_job and not user_wants_recruiter:
            continue
        
        # Strict Remote Check
        # Curated Indian platforms (Unstop/Cutshort/Hirist) may mix online/remote listings —
        # do NOT filter them by remote_preference; their curation already makes them relevant.
        location_lower = job.get('location', '').lower()
        is_remote_job = 'remote' in location_lower or 'work from home' in location_lower or 'remote' in title_lower
        if platform not in ['UNSTOP', 'CUTSHORT', 'HIRIST']:
            if remote_preference == 'only' and not is_remote_job:
                continue
            if remote_preference == 'none' and is_remote_job:
                continue

        # Strict Location Check
        is_indian_platform = platform in ['UNSTOP', 'CUTSHORT', 'HIRIST']
        # Country-level location names — when the user specifies a whole country, the
        # platform already filters results to that country via URL or API (e.g. in.indeed.com
        # for India). Applying a per-job location-string match would incorrectly remove all
        # city-named jobs ("Bangalore", "Hyderabad") that don't contain the country word.
        COUNTRY_NAMES = {
            'india', 'usa', 'us', 'uk', 'australia', 'canada', 'germany', 'singapore',
            'united states', 'united kingdom', 'new zealand', 'france', 'netherlands',
            'remote', 'worldwide',
        }
        all_locs_are_countries = bool(locations) and all(
            loc.strip().lower() in COUNTRY_NAMES for loc in locations
        )

        if locations and remote_preference != 'only' and not is_indian_platform and not all_locs_are_countries:
            # Remote jobs are worldwide — always accept them when remote is allowed
            if is_remote_job and remote_preference == 'include':
                pass  # worldwide remote: location check skipped
            else:
                location_matched = False
                for loc in locations:
                    if loc.lower() in location_lower:
                        location_matched = True
                        break
                if not location_matched:
                    continue

        # Indian curated platforms have their own relevance curation — skip keyword filtering
        if is_indian_platform:
            final_jobs.append(job)
            continue


        # Make keyword matching stricter to avoid fetching unrelated jobs
        title_match = keyword_lower in title_lower or any(core_kw in title_lower for core_kw in core_keywords)
        # Require keyword to be mentioned at least 3 times in description if not in title
        desc_keyword_count = sum(desc_lower.count(core_kw) for core_kw in core_keywords)

        if title_match or desc_keyword_count >= 3:
            final_jobs.append(job)
    
    if len(unique_jobs) > 0 and len(final_jobs) < len(unique_jobs):
        print(f"[DEBUG] Filtered out {len(unique_jobs) - len(final_jobs)} jobs based on strict location/remote/role filtering", file=sys.stderr)

    print(json.dumps({'status': 'success', 'jobs': final_jobs}))

async def main():
    if len(sys.argv) < 2:
        print(json.dumps({"status": "failed", "message": "No input provided"}))
        sys.exit(1)
    
    try:
        input_data = json.loads(sys.argv[1])
    except Exception as e:
        print(json.dumps({"status": "failed", "message": "Invalid JSON input"}))
        sys.exit(1)
    
    try:
        await run_scraper(input_data)
    except Exception as e:
        print(json.dumps({"status": "failed", "message": str(e)}))
        sys.exit(1)

if __name__ == "__main__":
    asyncio.run(main())
