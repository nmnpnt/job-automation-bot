<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationFailedNotification extends Notification
{
    use Queueable;

    protected $application;
    protected $channels;

    /**
     * Create a new notification instance.
     */
    public function __construct($application, array $channels = ['database'])
    {
        $this->application = $application;
        $this->channels = $channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->channels;
    }

    public function toDiscord($notifiable)
    {
        $url = url('/applications/' . $this->application->id);
        
        return [
            'content' => "🚨 **Application Failed**",
            'embeds' => [
                [
                    'title' => "Failed to apply to {$this->application->job->title}",
                    'description' => "The automation failed for {$this->application->job->company_name}.",
                    'url' => $url,
                    'color' => 16711680, // Red
                    'fields' => [
                        ['name' => 'Platform', 'value' => $this->application->job->platform, 'inline' => true],
                        ['name' => 'Error', 'value' => $this->application->notes ?? 'Unknown error', 'inline' => false],
                    ],
                ]
            ]
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'message' => 'Application failed for ' . $this->application->job->title,
        ];
    }
}
