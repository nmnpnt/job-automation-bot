<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;

class SystemSlackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $type;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $message, string $type = 'info', array $data = [])
    {
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Only send if the user has Slack notifications enabled and a webhook URL is configured.
        if ($notifiable->notificationPreferences && $notifiable->notificationPreferences->channel_slack && $notifiable->notificationPreferences->slack_webhook_url) {
            return ['slack'];
        }

        return [];
    }

    /**
     * Get the Slack representation of the notification.
     */
    public function toSlack(object $notifiable): SlackMessage
    {
        $colors = [
            'info' => 'good',
            'success' => 'good',
            'warning' => 'warning',
            'error' => 'danger',
        ];

        $color = $colors[$this->type] ?? 'good';

        $slack = (new SlackMessage)
            ->text($this->message)
            ->color($color);

        if (!empty($this->data)) {
            // Optional: attach data fields if present
            // In a real implementation we could iterate through $this->data to add fields.
        }

        return $slack;
    }
}
