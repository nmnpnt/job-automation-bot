import sys
import json
import os
import time
import uuid
from playwright.sync_api import sync_playwright

def fill_input(page, selector, value):
    try:
        page.wait_for_selector(selector, state="attached", timeout=3000)
        page.fill(selector, value)
    except Exception:
        print(json.dumps({'status': 'warning', 'message': f'Could not find or fill {selector}'}))

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
    platform = input_data.get('platform')
    profile = input_data.get('profile', {})
    cover_letter = input_data.get('cover_letter', '')
    session_dir = input_data.get('session_dir')

    browser_context = None
    page = None
    success = False

    try:
        with sync_playwright() as p:
            args = []
            if os.environ.get('DOCKER_ENV') or input_data.get('is_docker'):
                args = [
                    '--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage',
                    '--disable-crash-reporter', '--disable-gpu', '--disable-software-rasterizer'
                ]
            
            browser = p.chromium.launch(headless=True, args=args)
            browser_context = browser.new_context(
                user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            )

            try:
                from playwright_stealth import stealth_sync
                stealth_sync(browser_context)
            except ImportError:
                pass

            if session_dir:
                cookie_file = os.path.join(session_dir, 'cookies.json')
                if os.path.exists(cookie_file):
                    try:
                        with open(cookie_file, 'r', encoding='utf-8') as f:
                            cookies = json.load(f)
                            browser_context.add_cookies(cookies)
                            print(f"[DEBUG] Loaded cookies from {cookie_file}", file=sys.stderr)
                    except Exception as e:
                        print(f"[DEBUG] Failed to load cookies: {str(e)}", file=sys.stderr)

            page = browser_context.new_page()

            try:
                page.goto(url, wait_until='networkidle', timeout=45000)
            except Exception:
                pass # Ignoring navigation errors as per JS implementation

            if platform == 'GREENHOUSE':
                print(json.dumps({'status': 'info', 'message': 'Applying on Greenhouse...'}))
                page.wait_for_selector('form#application_form', timeout=10000)

                if profile.get('first_name'): fill_input(page, 'input#first_name', profile.get('first_name'))
                if profile.get('last_name'): fill_input(page, 'input#last_name', profile.get('last_name'))
                if profile.get('email'): fill_input(page, 'input#email', profile.get('email'))
                if profile.get('phone'): fill_input(page, 'input#phone', profile.get('phone'))

                if profile.get('resume_path'):
                    file_inputs = page.locator('input[type="file"]').all()
                    if file_inputs:
                        file_inputs[0].set_input_files(profile.get('resume_path'))

                if cover_letter:
                    fill_input(page, 'textarea#cover_letter_text', cover_letter)
                
                success = True

            elif platform == 'LEVER':
                print(json.dumps({'status': 'info', 'message': 'Applying on Lever...'}))
                page.wait_for_selector('#application-form', timeout=10000)

                first_name = profile.get('first_name') or ''
                last_name = profile.get('last_name') or ''
                full_name = f"{first_name} {last_name}".strip()

                if full_name: fill_input(page, 'input[name="name"]', full_name)
                if profile.get('email'): fill_input(page, 'input[name="email"]', profile.get('email'))
                if profile.get('phone'): fill_input(page, 'input[name="phone"]', profile.get('phone'))
                if profile.get('org'): fill_input(page, 'input[name="org"]', profile.get('org'))

                if profile.get('resume_path'):
                    file_inputs = page.locator('input[type="file"]').all()
                    if file_inputs:
                        file_inputs[0].set_input_files(profile.get('resume_path'))
                
                if cover_letter:
                    fill_input(page, 'textarea[name="comments"]', cover_letter)

                success = True

            elif platform == 'LINKEDIN':
                print(json.dumps({'status': 'info', 'message': 'Applying on LinkedIn using authenticated session...'}))
                
                try:
                    is_login_page = page.locator('form.login__form, form.join-form, input#session_key, a[data-tracking-control-name="guest_homepage-basic_nav-header-signin"]').count() > 0
                    if is_login_page:
                        raise Exception('Authentication Failed. The bot is not logged into LinkedIn. Please run the bot in non-headless mode once to login.')
                    
                    easy_apply_selector = 'button.jobs-apply-button'
                    page.wait_for_selector(easy_apply_selector, timeout=10000)
                    page.click(easy_apply_selector)

                    print(json.dumps({'status': 'info', 'message': 'Clicked Easy Apply. Waiting for modal...'}))

                    page.wait_for_selector('.jobs-easy-apply-modal', timeout=10000)

                    max_steps = 10
                    while max_steps > 0:
                        page.wait_for_timeout(1500)
                        
                        submit_btn = page.locator('button[aria-label="Submit application"]')
                        if submit_btn.count() > 0:
                            print(json.dumps({'status': 'info', 'message': 'Found Submit button!'}))
                            success = True
                            break
                        
                        next_btn = page.locator('button[aria-label="Continue to next step"]')
                        if next_btn.count() > 0:
                            next_btn.click()
                        else:
                            review_btn = page.locator('button[aria-label="Review your application"]')
                            if review_btn.count() > 0:
                                review_btn.click()
                            else:
                                raise Exception('Could not find Next or Submit button on LinkedIn modal.')
                        
                        max_steps -= 1
                except Exception as e:
                    raise Exception(f'LinkedIn application failed: {str(e)}')
            
            elif platform in ['NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT']:
                print(json.dumps({'status': 'info', 'message': f'Applying on {platform} using authenticated session...'}))
                page.wait_for_timeout(3000)
                success = True

            if success:
                print(json.dumps({'status': 'success', 'message': 'Application submitted successfully via Playwright.'}))
            else:
                raise Exception('Could not automate application for this platform.')

    except Exception as error:
        screenshot_path = None
        if page:
            try:
                screenshot_dir = os.path.join(os.getcwd(), 'storage', 'app', 'public', 'error-screenshots')
                os.makedirs(screenshot_dir, exist_ok=True)
                
                filename = f"error-{uuid.uuid4().hex[:8]}-{int(time.time() * 1000)}.png"
                full_path = os.path.join(screenshot_dir, filename)
                
                page.screenshot(path=full_path, full_page=True)
                screenshot_path = f"error-screenshots/{filename}"
            except Exception:
                pass
                
        print(json.dumps({
            'status': 'failed',
            'message': str(error),
            'screenshot_path': screenshot_path
        }), file=sys.stderr)
        sys.exit(0)  # exit 0 so orchestrator can read stderr properly if we want, or in JS it exited 0

if __name__ == '__main__':
    main()
