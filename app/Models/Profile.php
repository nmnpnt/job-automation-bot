<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'resume_path',
        'resume_text',
        'target_roles',
        'target_locations',
        'remote_preference',
        'max_job_age_days',
        'scraping_status',
        'last_scraped_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
