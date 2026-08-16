<?php

namespace App\Services;

use App\Models\NotificationPreference;
use App\Models\Application;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\...

class NotificationEngine
{
    public function send(Application $application, string $eventType, $notificationClass)
    {
        // For simplicity, we assume application has a related user (if multi-user)
        // or we just grab the first user's preferences for this single-tenant system.
        $preference = NotificationPreference::first();
        if (!$preference) {
            return;
        }

        if (!$this->shouldNotify($preference, $eventType)) {
            return;
        }

        $channels = $this->getActiveChannels($preference);
        if (empty($channels)) {
            return;
        }

        // Send the notification using Laravel's Notification facade
        // Normally we'd send it to a Notifiable model, e.g., the User.
        if ($preference->user) {
            Notification::send($preference->user, new $notificationClass($application, $channels));
            \Log::info("Notification Sent: {$eventType} via " . implode(', ', $channels));
        }
    }

    protected function shouldNotify(NotificationPreference $pref, string $eventType): bool
    {
        return match ($eventType) {
            'ApplicationSubmitted' => $pref->notify_on_submitted,
            'ExternalApplicationDetected' => $pref->notify_on_external,
            'CompanyWebsiteDetected' => $pref->notify_on_company_website,
            'ApplicationFailed' => $pref->notify_on_failed,
            'ManualActionRequired' => $pref->notify_on_manual_required,
            'DuplicateApplicationDetected' => $pref->notify_on_duplicate,
            default => true,
        };
    }

    protected function getActiveChannels(NotificationPreference $pref): array
    {
        $channels = [];
        if ($pref->channel_in_app) $channels[] = 'database';
        if ($pref->channel_email) $channels[] = 'mail';
        if ($pref->channel_push) $channels[] = 'broadcast';
        if ($pref->channel_discord) $channels[] = \App\Channels\DiscordWebhookChannel::class;
        
        return $channels;
    }
}
