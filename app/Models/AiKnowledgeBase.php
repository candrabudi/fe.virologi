<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiKnowledgeBase extends Model
{
    protected $table = 'ai_knowledge_base';

    protected $fillable = [
        'category',
        'topic',
        'content',
        'context',
        'examples',
        'references',
        'tags',
        'embedding',
        'usage_count',
        'relevance_score',
        'source',
        'created_by',
        'last_used_at',
    ];

    protected $casts = [
        'examples' => 'array',
        'references' => 'array',
        'tags' => 'array',
        'usage_count' => 'integer',
        'relevance_score' => 'decimal:2',
        'last_used_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Increment usage count and update last used timestamp
     */
    public function recordUsage(): void
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Search knowledge base by topic/content
     */
    public static function search(string $query, ?string $category = null)
    {
        $search = self::whereFullText(['topic', 'content'], $query);

        if ($category) {
            $search->where('category', $category);
        }

        return $search->orderByDesc('relevance_score')
            ->orderByDesc('usage_count')
            ->limit(10)
            ->get();
    }

    /**
     * Get most relevant knowledge for a query
     */
    public static function getRelevantKnowledge(string $query, int $limit = 5)
    {
        return self::whereFullText(['topic', 'content'], $query)
            ->where('relevance_score', '>=', 3.0)
            ->orderByDesc('relevance_score')
            ->limit($limit)
            ->get();
    }
}
