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
        'submitted_at' => 'datetime',
        'last_attempt_at' => 'datetime',
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
