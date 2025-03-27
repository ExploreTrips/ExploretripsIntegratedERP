<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'id',
        'code',
        'full_name',
    ];

    public static function languageData($code)
    {
        $cacheKey = 'language_data_' . $code;
        return cache()->remember($cacheKey, now()->addHours(24), function () use ($code) {
            return Language::where('code', $code)->first();
        });
    }
}
