<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'subtitle',
        'summary',
        'content',
        'level',
        'topic',
        'chapters',
        'learning_objectives',
        'ai_keywords',
        'cover_image',
        'file_path',
        'file_type',
        'page_count',
        'author',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'chapters' => 'array',
        'learning_objectives' => 'array',
        'ai_keywords' => 'array',
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'date',
        'sort_order' => 'integer',
        'page_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
