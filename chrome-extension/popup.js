document.addEventListener('DOMContentLoaded', () => {
    // Load existing settings
    chrome.storage.sync.get(['apiUrl', 'apiToken', 'autoApplyEnabled'], (result) => {
        if (result.apiUrl) document.getElementById('apiUrl').value = result.apiUrl;
        if (result.apiToken) document.getElementById('apiToken').value = result.apiToken;
        if (result.autoApplyEnabled !== undefined) document.getElementById('autoApplyToggle').checked = result.autoApplyEnabled;
    });

    // Save settings
    document.getElementById('saveBtn').addEventListener('click', () => {
        const apiUrl = document.getElementById('apiUrl').value.replace(/\/$/, '');
        const apiToken = document.getElementById('apiToken').value;
        const autoApplyEnabled = document.getElementById('autoApplyToggle').checked;
        const statusMsg = document.getElementById('statusMsg');

        chrome.storage.sync.set({ apiUrl, apiToken, autoApplyEnabled }, () => {
            statusMsg.textContent = 'Settings saved successfully!';
            statusMsg.className = 'status success';
            setTimeout(() => {
                statusMsg.className = 'status';
            }, 3000);
        });
    });
});
