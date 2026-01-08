<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CyberSecurityService extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'short_name',
        'thumbnail',
        'category',
        'summary',
        'description',
        'service_scope',
        'deliverables',
        'target_audience',
        'ai_keywords',
        'ai_domain',
        'is_ai_visible',
        'cta_label',
        'cta_url',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'service_scope' => 'array',
        'deliverables' => 'array',
        'target_audience' => 'array',
        'ai_keywords' => 'array',
        'seo_keywords' => 'array',
        'is_ai_visible' => 'boolean',
        'is_active' => 'boolean',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
