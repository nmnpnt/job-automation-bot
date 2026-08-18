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

    public function routeNotificationForSlack(Notification $notification): mixed
    {
        return $this->notificationPreferences?->slack_webhook_url;
    }

    public function sendSlackNotification(string $message, string $type = 'info', ?string $prefKey = null): void
    {
        $prefs = $this->notificationPreferences;
        if ($prefs && $prefs->channel_slack && $prefs->slack_webhook_url) {
            if (!$prefKey || $prefs->{$prefKey}) {
                $this->notify(new \App\Notifications\SystemSlackNotification($message, $type));
            }
        }
    }
}
