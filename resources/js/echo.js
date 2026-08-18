import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || '12345',
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8081,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8081,
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
