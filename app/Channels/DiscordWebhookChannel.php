<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class DiscordWebhookChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toDiscord')) {
            $message = $notification->toDiscord($notifiable);
            
            // Check if the user has a discord webhook configured
            $preferences = $notifiable->notificationPreferences;
            
            if (!$preferences || !$preferences->channel_discord || empty($preferences->discord_webhook_url)) {
                return;
            }

            Http::post($preferences->discord_webhook_url, [
                'content' => $message['content'] ?? '',
                'embeds' => $message['embeds'] ?? []
            ]);
        }
    }
}
