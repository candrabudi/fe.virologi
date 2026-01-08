<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'section_name',
        'title',
        'subtitle',
        'description',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'badge_text',
        'background_image',
        'settings',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * Scope untuk mendapatkan section yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope untuk mendapatkan section berdasarkan key
     */
    public function scopeByKey($query, $key)
    {
        return $query->where('section_key', $key);
    }
}
