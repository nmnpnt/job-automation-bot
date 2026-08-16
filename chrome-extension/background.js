// Service worker for Chrome Extension
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === 'sendJobToBackend') {
        chrome.storage.sync.get(['apiUrl', 'apiToken'], (config) => {
            if (!config.apiUrl || !config.apiToken) {
                console.error('API configuration missing.');
                sendResponse({ success: false, error: 'API configuration missing.' });
                return;
            }

            // We are using the existing job injection endpoint or creating a new one.
            // For now, let's assume we post to /api/extension/jobs
            fetch(`${config.apiUrl}/api/extension/jobs`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${config.apiToken}`
                },
                body: JSON.stringify(request.jobData)
            })
            .then(res => res.json())
            .then(data => {
                console.log('Successfully sent job to backend', data);
                sendResponse({ success: true, data });
            })
            .catch(error => {
                console.error('Failed to send job', error);
                sendResponse({ success: false, error: error.toString() });
            });
        });
        
        return true; // Keep the message channel open for async response
    }
});
