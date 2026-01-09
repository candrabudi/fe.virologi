<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeakCheckSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_endpoint',
        'api_token',
        'default_limit',
        'lang',
        'bot_name',
        'is_enabled',
    ];

    /**
     * Get the active setting or create default.
     */
    public static function getActive()
    {
        return self::firstOrCreate([], [
            'api_endpoint' => 'https://leakosintapi.com/',
            'default_limit' => 100,
            'lang' => 'en',
            'is_enabled' => true,
        ]);
    }
}
