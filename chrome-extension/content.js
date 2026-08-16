// content.js - Injected into job pages to extract data
console.log('AutoApply Chrome Extension active.');

let lastExtractedUrl = '';

// Main extraction logic
function extractAndSendJob() {
    const currentUrl = window.location.href;
    
    // Prevent duplicate sending for the same job (especially on SPA sites like LinkedIn)
    if (currentUrl === lastExtractedUrl) return;
    
    chrome.storage.sync.get(['autoApplyEnabled'], (config) => {
        if (!config.autoApplyEnabled) return;

        let jobData = null;

        // LinkedIn Detection
        if (currentUrl.includes('linkedin.com/jobs/view/') || currentUrl.includes('linkedin.com/jobs/collections/')) {
            jobData = extractLinkedInJob();
        } 
        // Naukri Detection
        else if (currentUrl.includes('naukri.com/job-listings')) {
            jobData = extractNaukriJob();
        }

        if (jobData && jobData.title && jobData.company) {
            console.log('AutoApply: Extracted Job Data', jobData);
            lastExtractedUrl = currentUrl;
            
            // Send to background service worker
            chrome.runtime.sendMessage({
                action: 'sendJobToBackend',
                jobData: jobData
            }, (response) => {
                if (response && response.success) {
                    showSuccessToast(`Job synced: ${jobData.title}`);
                }
            });
        }
    });
}

function extractLinkedInJob() {
    try {
        const titleEl = document.querySelector('.job-details-jobs-unified-top-card__job-title h1') || 
                        document.querySelector('.top-card-layout__title');
        const companyEl = document.querySelector('.job-details-jobs-unified-top-card__company-name a') || 
                          document.querySelector('.topcard__org-name-link');
        const locationEl = document.querySelector('.job-details-jobs-unified-top-card__primary-description span:nth-child(2)') ||
                           document.querySelector('.topcard__flavor--bullet');
        const url = window.location.href.split('?')[0]; // Clean URL

        if (!titleEl) return null;

        return {
            platform: 'LINKEDIN',
            title: titleEl.innerText.trim(),
            company: companyEl ? companyEl.innerText.trim() : 'Unknown Company',
            location: locationEl ? locationEl.innerText.trim() : 'Unknown Location',
            url: url
        };
    } catch (e) {
        console.error('LinkedIn extraction failed:', e);
        return null;
    }
}

function extractNaukriJob() {
    try {
        const titleEl = document.querySelector('.jd-header-title');
        const companyEl = document.querySelector('.jd-header-comp-name a');
        const locationEl = document.querySelector('.loc .locWdth');
        const url = window.location.href.split('?')[0];

        if (!titleEl) return null;

        return {
            platform: 'NAUKRI',
            title: titleEl.innerText.trim(),
            company: companyEl ? companyEl.innerText.trim() : 'Unknown Company',
            location: locationEl ? locationEl.innerText.trim() : 'Unknown Location',
            url: url
        };
    } catch (e) {
        console.error('Naukri extraction failed:', e);
        return null;
    }
}

// Minimal toast UI for feedback
function showSuccessToast(message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-family: sans-serif;
        font-size: 14px;
        font-weight: bold;
        z-index: 999999;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: opacity 0.5s;
    `;
    toast.innerText = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Observe DOM changes (since LinkedIn/Naukri are SPAs, the URL changes without page reload)
let lastUrl = location.href; 
new MutationObserver(() => {
    const url = location.href;
    if (url !== lastUrl) {
        lastUrl = url;
        setTimeout(extractAndSendJob, 2000); // Wait for new DOM to render
    }
}).observe(document, {subtree: true, childList: true});

// Initial run
setTimeout(extractAndSendJob, 2000);
