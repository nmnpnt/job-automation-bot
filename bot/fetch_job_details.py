import sys
import json
import os
import time
import re
from playwright.sync_api import sync_playwright

def format_node_text(page, selector):
    return page.evaluate("""(sel) => {
        const node = document.querySelector(sel);
        if (!node) return '';
        const listItems = node.querySelectorAll('li');
        listItems.forEach(li => {
            const text = li.innerText.trim();
            if (text && !text.startsWith('•') && !text.startsWith('-')) {
                li.innerText = '• ' + li.innerText;
            }
        });
        return node.innerText.trim();
    }""", selector)

def format_node_text_by_element(page, element_handle):
    if not element_handle: return ''
    return element_handle.evaluate("""(node) => {
        if (!node) return '';
        const listItems = node.querySelectorAll('li');
        listItems.forEach(li => {
            const text = li.innerText.trim();
            if (text && !text.startsWith('•') && !text.startsWith('-')) {
                li.innerText = '• ' + li.innerText;
            }
        });
        return node.innerText.trim();
    }""")

def main():
    if len(sys.argv) < 2:
        print(json.dumps({'status': 'failed', 'message': 'No input provided'}))
        sys.exit(1)

    try:
        input_data = json.loads(sys.argv[1])
    except Exception as e:
        print(json.dumps({'status': 'failed', 'message': 'Invalid JSON input'}))
        sys.exit(1)

    url = input_data.get('url')
    platform = input_data.get('platform', '')
    session_dir = input_data.get('session_dir')

    if not url:
        print(json.dumps({'status': 'failed', 'message': 'Missing URL'}))
        sys.exit(1)

    target_url = url
    if 'linkedin.com/jobs' in url:
        view_match = re.search(r'view/(\d+)', url)
        id_match = re.search(r'currentJobId=(\d+)', url)
        job_id = view_match.group(1) if view_match else (id_match.group(1) if id_match else None)
        if job_id:
            target_url = f'https://www.linkedin.com/jobs-guest/jobs/api/jobPosting/{job_id}'

    try:
        with sync_playwright() as p:
            args = []
            if os.environ.get('DOCKER_ENV') or input_data.get('is_docker'):
                args = [
                    '--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage',
                    '--disable-crash-reporter', '--disable-gpu', '--disable-software-rasterizer'
                ]
            
            browser = p.chromium.launch(headless=True, args=args)
            context = browser.new_context(
                user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            )

            # stealth setup (if using stealth package, typically requires playwright-stealth)
            try:
                from playwright_stealth import stealth_sync
                stealth_sync(context)
            except ImportError:
                pass # Playwright stealth not available or failed to import

            if session_dir:
                cookie_file = os.path.join(session_dir, 'cookies.json')
                if os.path.exists(cookie_file):
                    try:
                        with open(cookie_file, 'r', encoding='utf-8') as f:
                            cookies = json.load(f)
                            # playwright accepts a list of dicts for cookies
                            context.add_cookies(cookies)
                    except Exception:
                        pass

            page = context.new_page()

            page.goto(target_url, wait_until='domcontentloaded', timeout=45000)
            page.wait_for_timeout(3000)

            for i in range(3):
                page.evaluate(f"window.scrollTo(0, document.body.scrollHeight / 3 * {i+1})")
                page.wait_for_timeout(1000)

            description = ''
            skills = ''

            for attempt in range(5):
                if platform == 'LINKEDIN' or 'linkedin.com' in page.url:
                    description = format_node_text(page, '.jobs-description-content__text, .show-more-less-html__markup, .description__text')
                    if not description:
                        description = page.evaluate("document.body.innerText.trim()")
                elif platform == 'INDEED':
                    description = format_node_text(page, '#jobDescriptionText')
                else:
                    specific_selectors = [
                        '.job-desc', 'section.job-desc', '.dang-inner-html', 
                        '[class*="styles_job-desc-container__"]', '[class*="styles_JDC__"]', '[class*="JobDescription"]', # Naukri
                        '.job-detail-content', # Uplers
                        '.competition-details', '.detail-container', # Unstop
                        '.job-details-wrapper', # Hirist
                        '.job-desc-content', '.job-details-container', # Cutshort
                        '#content', 'div[id="content"]', '.job__description', # Greenhouse
                        '.section-wrapper.page-full-width', # Lever
                        '#JobDescriptionContainer', '.jobDescriptionContent', # Glassdoor
                        '[data-automation-id="jobPostingDescription"]', # Workday
                        '#about-role', '[data-test="JobProfileAbout"]', # Wellfound / AngelList
                    ]

                    for selector in specific_selectors:
                        try:
                            node = page.locator(selector).first
                            if node.count() > 0 and len(node.inner_text() or '') > 100:
                                description = format_node_text_by_element(page, node.element_handle())
                                break
                        except Exception:
                            continue
                    
                    if not description:
                        try:
                            nodes = page.locator('[class*="job-desc"], [class*="JobDesc"]').all()
                            for node in nodes:
                                if len(node.inner_text() or '') > 200:
                                    description = format_node_text_by_element(page, node.element_handle())
                                    break
                        except Exception:
                            pass

                    if not description:
                        try:
                            nodes = page.locator('main, article, .job-description, .description, #job-details').all()
                            for node in nodes:
                                if len(node.inner_text() or '') > 200:
                                    description = format_node_text_by_element(page, node.element_handle())
                                    break
                        except Exception:
                            pass
                    
                    if not description:
                        try:
                            body_text = page.evaluate("document.body.innerText.trim()")
                            if len(body_text) > 200:
                                description = body_text[:5000]
                        except Exception:
                            pass

                if description and len(description) > 100:
                    break

                page.wait_for_timeout(1000)

            details = {
                'description': description,
                'skills': skills
            }

            browser.close()
            print(json.dumps({'status': 'success', 'details': details}))

    except Exception as e:
        print(json.dumps({'status': 'failed', 'message': str(e)}))
        sys.exit(1)

if __name__ == '__main__':
    main()
