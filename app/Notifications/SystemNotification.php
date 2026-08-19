<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;

class SystemNotification extends Notification
{

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
     * Only delivers to the database (in-app notification bell).
     * Slack is sent directly in User::sendSlackNotification() to avoid SSL issues.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the Slack representation of the notification.
     */
    public function toSlack(object $notifiable): SlackMessage
    {
        $emojis = [
            'info' => 'ℹ️',
            'success' => '✅',
            'warning' => '⚠️',
            'error' => '🚨',
        ];

        $emoji = $emojis[$this->type] ?? 'ℹ️';

        $slack = (new SlackMessage)
            ->text("{$emoji} " . $this->message);

        if (!empty($this->data)) {
            // Optional: attach data fields if present
            // In a real implementation we could iterate through $this->data to add fields.
        }

        return $slack;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'data' => $this->data,
        ];
    }
}
