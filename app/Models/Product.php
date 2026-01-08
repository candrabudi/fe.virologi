<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'subtitle',
        'summary',
        'content',
        'product_type',
        'ai_domain',
        'ai_level',
        'ai_keywords',
        'ai_intents',
        'ai_use_cases',
        'ai_priority',
        'is_ai_visible',
        'is_ai_recommended',
        'cta_label',
        'cta_url',
        'cta_type',
        'thumbnail',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'ai_view_count',
        'ai_click_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'ai_keywords' => 'array',
        'ai_intents' => 'array',
        'ai_use_cases' => 'array',
        'seo_keywords' => 'array',
        'is_ai_visible' => 'boolean',
        'is_ai_recommended' => 'boolean',
        'is_active' => 'boolean',
        'ai_priority' => 'integer',
        'ai_view_count' => 'integer',
        'ai_click_count' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function scopeAiVisible($query)
    {
        return $query->where('is_ai_visible', true);
    }

    public function scopeAiRecommended($query)
    {
        return $query->where('is_ai_recommended', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeByDomain($query, $domain)
    {
        return $query->where('ai_domain', $domain);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('ai_level', $level);
    }
}
