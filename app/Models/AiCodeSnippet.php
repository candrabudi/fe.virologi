<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCodeSnippet extends Model
{
    protected $fillable = [
        'language',
        'category',
        'title',
        'description',
        'secure_code',
        'insecure_code',
        'explanation',
        'security_benefits',
        'test_cases',
        'dependencies',
        'usage_count',
        'rating',
        'is_verified',
    ];

    protected $casts = [
        'security_benefits' => 'array',
        'test_cases' => 'array',
        'dependencies' => 'array',
        'usage_count' => 'integer',
        'rating' => 'decimal:2',
        'is_verified' => 'boolean',
    ];
}
