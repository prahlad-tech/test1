<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    protected $fillable = [
        'original_url',
        'short_code', 
        'clicks'
    ];

    // Short code generate करने के लिए
    public static function generateShortCode(): string
    {
        do {
            $shortCode = Str::random(6);
        } while (self::where('short_code', $shortCode)->exists());

        return $shortCode;
    }

    // Full shortened URL get करने के लिए
    public function getShortenedUrlAttribute(): string
    {
        return url($this->short_code);
    }
}