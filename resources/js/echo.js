import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: '12345',
    wsHost: '127.0.0.1',
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

window.Echo.channel('activity-feed')
    .listen('.ActivityLogged', (e) => {
        console.log('Echo received activity-logged:', e);
        const jobTitle = e.application ? (e.application.job_title || 'Job') : 'Job';
        window.dispatchEvent(new CustomEvent('activity-logged', { 
            detail: { message: e.message, title: 'Update: ' + jobTitle } 
        }));
    });
