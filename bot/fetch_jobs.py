import sys
import json
import asyncio
import os
import time
from urllib.parse import urlparse
from playwright.async_api import async_playwright

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
    else:
        async with async_playwright() as p:
            browser = await p.chromium.launch(
                headless=False,
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
        
            cookie_file = os.path.join(session_dir, 'cookies.json') if session_dir else None
            if cookie_file and os.path.exists(cookie_file):
                try:
                    with open(cookie_file, 'r') as f:
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
                    search_url = f"https://www.indeed.com/jobs?q={keyword}&l={loc}"
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
                    job_selector = 'li, .job-card-container, .job-search-card'
                elif platform == 'NAUKRI':
                    if loc:
                        search_url = f"https://www.naukri.com/{keyword.replace(' ', '-')}-jobs-in-{loc.replace(' ', '-')}"
                    else:
                        search_url = f"https://www.naukri.com/{keyword.replace(' ', '-')}-jobs"
                
                    if str(max_job_age_days) in ['1', '7', '14', '30']:
                        search_url += f"?jobAge={max_job_age_days}"
                    
                    job_selector = '.srp-jobtuple-wrapper'
                elif platform == 'UPLERS':
                    search_url = f"https://platform.uplers.com/talent/jobs?search={keyword}"
                    job_selector = '.job-card'
                else:
                    raise Exception('Unknown platform')

                try:
                    print(f"[DEBUG] Loading {search_url}", file=sys.stderr)
                    await page.goto(search_url, wait_until='domcontentloaded', timeout=60000)
                    await page.wait_for_timeout(3000)

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
                                const link = node.querySelector('h2.jobTitle a');
                                if (link) {
                                    url = link.href;
                                    title = link.querySelector('span') ? link.querySelector('span').innerText : link.innerText;
                                }
                                const comp = node.querySelector('[data-testid="company-name"]');
                                if (comp) company = comp.innerText.trim();
                                const locationNode = node.querySelector('[data-testid="text-location"]');
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
                            } else {
                                const link = node.querySelector('a');
                                url = link ? link.href : window.location.href;
                                title = node.innerText.split('\\n')[0];
                            }
                        
                            if (url) {
                                try {
                                    const parsedUrl = new URL(url);
                                    url = parsedUrl.origin + parsedUrl.pathname;
                                } catch (e) {}
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
                        
                if platform in ['UNSTOP', 'CUTSHORT', 'HIRIST']:
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
    
    if 'browser' in locals():
        await browser.close()
    
    # Strict keyword filtering to fix fuzzy search issues
    final_jobs = []
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
        location_lower = job.get('location', '').lower()
        is_remote_job = 'remote' in location_lower or 'remote' in title_lower
        if remote_preference == 'only' and not is_remote_job:
            continue
        if remote_preference == 'none' and is_remote_job:
            continue

        # Strict Location Check (if not remote-only)
        if locations and remote_preference != 'only':
            location_matched = False
            for loc in locations:
                if loc.lower() in location_lower:
                    location_matched = True
                    break
        
            if remote_preference == 'include' and is_remote_job:
                location_matched = True
            
            if not location_matched and not is_remote_job:
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
