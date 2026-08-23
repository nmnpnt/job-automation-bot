import sys
import json
import subprocess
from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse

app = FastAPI(title="Job Automation Scraper API")

def run_script(script_name: str, payload: dict):
    try:
        # We use the python executable that is currently running the FastAPI server
        python_exe = sys.executable
        
        result = subprocess.run(
            [python_exe, script_name, json.dumps(payload)],
            capture_output=True,
            text=True,
            timeout=120  # Max 2 minutes for any scraping task
        )
        
        # Output is usually on stdout, but errors could be on stderr.
        # The scripts output JSON on stdout.
        output_lines = result.stdout.strip().split('\n')
        
        # Try to parse the last line as JSON (as PHP did)
        for line in reversed(output_lines):
            line = line.strip()
            if not line:
                continue
            try:
                parsed = json.loads(line)
                if 'status' in parsed:
                    return parsed
            except json.JSONDecodeError:
                pass
                
        # If we failed to parse anything, check stderr
        if result.stderr:
            return {"status": "failed", "message": "Script failed with error: " + result.stderr}
            
        return {"status": "failed", "message": "Failed to parse JSON output from script", "raw_output": result.stdout}
        
    except subprocess.TimeoutExpired:
        return {"status": "failed", "message": "Script execution timed out after 120 seconds"}
    except Exception as e:
        return {"status": "failed", "message": str(e)}

@app.post("/api/fetch_jobs")
async def fetch_jobs(request: Request):
    payload = await request.json()
    result = run_script("fetch_jobs.py", payload)
    return JSONResponse(content=result)

@app.post("/api/fetch_details")
async def fetch_details(request: Request):
    payload = await request.json()
    result = run_script("fetch_job_details.py", payload)
    return JSONResponse(content=result)

@app.post("/api/apply")
async def apply(request: Request):
    payload = await request.json()
    result = run_script("apply.py", payload)
    return JSONResponse(content=result)

@app.get("/health")
def health_check():
    return {"status": "ok"}
