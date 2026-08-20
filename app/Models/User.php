<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function notificationPreferences()
    {
        return $this->hasOne(NotificationPreference::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function routeNotificationForSlack(Notification $notification): mixed
    {
        return $this->notificationPreferences?->slack_webhook_url;
    }

    /**
     * Check a notification preference key safely — returns true if the key doesn't exist (unknown keys are treated as enabled).
     */
    protected function checkPref(?string $prefKey): bool
    {
        if (!$prefKey) return true;
        $prefs = $this->notificationPreferences;
        if (!$prefs) return false;
        // If the column doesn't exist on the model, default to true
        $arr = $prefs->toArray();
        return array_key_exists($prefKey, $arr) ? (bool) $arr[$prefKey] : true;
    }

    public function sendInAppNotification(string $message, string $type = 'info'): void
    {
        try {
            $this->notify(new \App\Notifications\SystemNotification($message, $type));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("In-app notification error: " . $e->getMessage());
        }
    }

    public function sendSlackNotification(string $message, string $type = 'info', ?string $prefKey = null): void
    {
        $prefs = $this->notificationPreferences;
        if ($prefs && $prefs->channel_slack && $prefs->slack_webhook_url) {
            if ($this->checkPref($prefKey)) {
                try {
                    // Send Slack directly (bypasses queue) using Guzzle with SSL verify disabled for local dev
                    $emoji = ['info' => 'ℹ️', 'success' => '✅', 'warning' => '⚠️', 'error' => '🚨'][$type] ?? 'ℹ️';
                    $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 10]);
                    $client->post($prefs->slack_webhook_url, [
                        'json' => ['text' => "{$emoji} {$message}"]
                    ]);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Slack notification error: " . $e->getMessage());
                }
            }
        }
    }

    public function sendWhatsAppNotification(string $message, ?string $prefKey = null): void
    {
        $prefs = $this->notificationPreferences;
        if ($prefs && $prefs->channel_whatsapp) {
            if ($this->checkPref($prefKey)) {
                try {
                    app(\App\Services\WhatsAppService::class)->send($this, $message);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("WhatsApp notification error: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Send a notification through all configured channels (in-app + Slack + WhatsApp).
     * Always sends in-app. Slack and WhatsApp are gated on user preferences.
     */
    public function notifyChannels(string $message, string $type = 'info', ?string $prefKey = null): void
    {
        // Always store in-app notification
        $this->sendInAppNotification($message, $type);
        // Send to external channels based on preferences
        $this->sendSlackNotification($message, $type, $prefKey);
        $this->sendWhatsAppNotification($message, $prefKey);
    }
}
