<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeAnalysis extends Model
{
    use HasFactory;

    protected $table = 'resume_analysis';

    protected $guarded = [];

    protected $casts = [
        'missing_keywords' => 'json',
        'suggestions' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
