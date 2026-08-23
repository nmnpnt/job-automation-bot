<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScrapingJob extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'id',
        'user_id',
        'schedule_id',
        'platforms',
        'status',
        'trigger_type',
        'total_urls_found',
        'processed_count',
        'failed_count',
        'started_at',
        'completed_at',
        'error_log',
    ];

    protected $casts = [
        'platforms' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(ScrapingSchedule::class, 'schedule_id');
    }
}
