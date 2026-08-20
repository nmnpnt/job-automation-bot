<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'content' => 'json',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
