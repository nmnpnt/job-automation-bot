<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'notify_on_submitted' => 'boolean',
        'notify_on_external' => 'boolean',
        'notify_on_company_website' => 'boolean',
        'notify_on_failed' => 'boolean',
        'notify_on_manual_required' => 'boolean',
        'notify_on_duplicate' => 'boolean',
        'notify_on_interview' => 'boolean',
        'daily_summary' => 'boolean',
        'channel_in_app' => 'boolean',
        'channel_email' => 'boolean',
        'channel_push' => 'boolean',
        'channel_telegram' => 'boolean',
        'channel_slack' => 'boolean',
        'channel_whatsapp' => 'boolean',
        'notify_on_high_match' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
