import sys
import json
import asyncio
import os
import time
from playwright.async_api import async_playwright

async def run_auth(input_data):
    platform = input_data.get('platform')
    session_dir = input_data.get('session_dir')
    cookie_file = input_data.get('cookie_file')
    
    if not os.path.exists(cookie_file):
        print(json.dumps({'status': 'failed', 'message': 'Cookie file not found.'}))
        sys.exit(1)

    try:
        with open(cookie_file, 'r', encoding='utf-8') as f:
            cookies = json.load(f)
            if not isinstance(cookies, list):
                raise Exception("Cookies must be a JSON array.")
    except Exception as e:
        print(json.dumps({'status': 'failed', 'message': 'Invalid cookie JSON format.'}))
        sys.exit(1)

    print(json.dumps({'status': 'info', 'message': f'Verifying cookies for {platform}...'}))

    async with async_playwright() as p:
        browser = await p.chromium.launch(
            headless=True,
            args=[
                '--disable-blink-features=AutomationControlled',
                '--no-sandbox',
                '--disable-dev-shm-usage',
            ]
        )
        
        context = await browser.new_context(
            user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        )
        
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
        
        try:
            await context.add_cookies(clean_cookies)
        except Exception as e:
            print(json.dumps({'status': 'failed', 'message': f'Failed to add cookies: {str(e)}'}))
            sys.exit(1)
            
        page = await context.new_page()
        
        try:
            from playwright_stealth import stealth_async
            await stealth_async(page)
        except ImportError:
            pass

        verify_url = ''
        if platform == 'LINKEDIN':
            verify_url = 'https://www.linkedin.com/feed/'
        elif platform == 'NAUKRI':
            verify_url = 'https://www.naukri.com/mnjuser/profile'
        elif platform == 'UPLERS':
            verify_url = 'https://platform.uplers.com/talent'
        elif platform == 'UNSTOP':
            verify_url = 'https://unstop.com/'
        elif platform == 'HIRIST':
            verify_url = 'https://www.hirist.tech/candidate/dashboard'
        elif platform == 'CUTSHORT':
            verify_url = 'https://cutshort.io/profile'
        elif platform == 'INDEED':
            verify_url = 'https://www.indeed.com/'
        else:
            print(json.dumps({'status': 'success', 'message': f'Cookies loaded for {platform}.'}))
            await browser.close()
            sys.exit(0)

        try:
            await page.goto(verify_url, wait_until='domcontentloaded', timeout=60000)
            await page.wait_for_timeout(3000)
            
            current_url = page.url
            if 'login' in current_url or 'checkpoint' in current_url or 'auth' in current_url:
                raise Exception(f'Redirected to {current_url}')
                
            print(json.dumps({'status': 'success', 'message': f'Authentication verified for {platform}. Session saved.'}))
        except Exception as e:
            current_url = page.url
            page_title = await page.title()
            
            try:
                screenshot_path = os.path.join(session_dir, 'error.png')
                await page.screenshot(path=screenshot_path)
                print(json.dumps({'status': 'failed', 'message': f'Cookie verification failed for {platform}. URL: {current_url} | Title: {page_title} | Error: {str(e)}. Screenshot saved.'}))
            except:
                print(json.dumps({'status': 'failed', 'message': f'Cookie verification failed for {platform}. URL: {current_url} | Title: {page_title} | Error: {str(e)}.'}))
            
            await browser.close()
            sys.exit(1)

        await browser.close()
        sys.exit(0)

async def main():
    if len(sys.argv) < 2:
        print(json.dumps({"status": "failed", "message": "No input provided"}))
        sys.exit(1)
        
    arg = sys.argv[1]
    try:
        # Check if argument is a file path
        if os.path.exists(arg) and arg.endswith('.json'):
            with open(arg, 'r', encoding='utf-8') as f:
                input_data = json.load(f)
        else:
            input_data = json.loads(arg)
    except Exception as e:
        print(json.dumps({"status": "failed", "message": "Invalid JSON input or file"}))
        sys.exit(1)
        
    try:
        await run_auth(input_data)
    except Exception as e:
        print(json.dumps({"status": "failed", "message": str(e)}))
        sys.exit(1)

if __name__ == "__main__":
    asyncio.run(main())
