<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(ResumeSection::class)->orderBy('order_index');
    }

    public function analyses()
    {
        return $this->hasMany(ResumeAnalysis::class);
    }

    public function getFullTextAttribute()
    {
        $text = "Resume Name: " . $this->name . "\n\n";
        foreach ($this->sections as $section) {
            $text .= strtoupper($section->type) . " - " . $section->title . ":\n";
            
            if (is_array($section->content)) {
                foreach ($section->content as $key => $value) {
                    if (!empty($value)) {
                        $keyLabel = ucfirst(str_replace('_', ' ', $key));
                        $text .= "{$keyLabel}: {$value}\n";
                    }
                }
            } else {
                $text .= $section->content . "\n";
            }
            
            $text .= "\n";
        }
        return trim($text);
    }
}
