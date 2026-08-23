<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ScrapingSchedule extends Model
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

        static::saving(function ($model) {
            $model->calculateNextRun();
        });
    }

    public function calculateNextRun()
    {
        if (!$this->is_active) {
            $this->next_run_at = null;
            return;
        }

        $tz = $this->timezone ?: 'UTC';
        $now = Carbon::now($tz);
        $time = Carbon::parse($this->time, $tz);
        
        $next = null;

        if ($this->frequency === 'once') {
            // Run today if time hasn't passed, else tomorrow
            $candidate = $now->copy()->setTimeFrom($time);
            if ($candidate->isPast()) {
                $candidate->addDay();
            }
            $next = $candidate;
        } elseif ($this->frequency === 'daily') {
            $candidate = $now->copy()->setTimeFrom($time);
            if ($candidate->isPast()) {
                $candidate->addDay();
            }
            $next = $candidate;
        } elseif ($this->frequency === 'weekly') {
            $daysMap = [
                'Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3,
                'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6
            ];
            $selectedDays = $this->days ?? [];
            
            if (empty($selectedDays)) {
                $this->next_run_at = null;
                return;
            }

            $candidates = [];
            foreach ($selectedDays as $dayName) {
                $dayOfWeek = $daysMap[$dayName] ?? null;
                if ($dayOfWeek === null) continue;

                $candidate = $now->copy()->next($dayOfWeek)->setTimeFrom($time);
                // If today is the day, and time hasn't passed, we can run today
                if ($now->dayOfWeek === $dayOfWeek) {
                    $todayCandidate = $now->copy()->setTimeFrom($time);
                    if ($todayCandidate->isFuture()) {
                        $candidate = $todayCandidate;
                    }
                }
                $candidates[] = $candidate;
            }

            if (!empty($candidates)) {
                // Sort to find the earliest future date
                usort($candidates, fn($a, $b) => $a->timestamp <=> $b->timestamp);
                $next = $candidates[0];
            }
        } elseif ($this->frequency === 'monthly') {
            // Assume 1st day of month for now if not specified in days
            $dayOfMonth = 1;
            if (is_array($this->days) && count($this->days) > 0) {
                $dayOfMonth = (int)$this->days[0];
            }

            $candidate = $now->copy()->day($dayOfMonth)->setTimeFrom($time);
            if ($candidate->isPast()) {
                $candidate->addMonth();
            }
            $next = $candidate;
        }

        if ($next) {
            $this->next_run_at = $next->setTimezone('UTC');
        }
    }

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'frequency',
        'time',
        'days',
        'timezone',
        'is_active',
        'next_run_at',
        'last_run_at',
    ];

    protected $casts = [
        'days' => 'array',
        'is_active' => 'boolean',
        'next_run_at' => 'datetime',
        'last_run_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(ScrapingJob::class, 'schedule_id');
    }
}
