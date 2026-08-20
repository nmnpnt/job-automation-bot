<?php

namespace App\Models;

use App\Enums\ApplicationSource;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'application_source' => ApplicationSource::class,
        'status' => ApplicationStatus::class,
        'can_auto_apply' => 'boolean',
        'is_read' => 'boolean',
        'is_saved' => 'boolean',
        'submitted_at' => 'datetime',
        'last_attempt_at' => 'datetime',
        'interview_scheduled_at' => 'datetime',
        'posted_at' => 'datetime',
        'application_deadline' => 'datetime',
    ];

    public function events()
    {
        return $this->hasMany(ApplicationEvent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
