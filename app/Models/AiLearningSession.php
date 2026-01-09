<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiLearningSession extends Model
{
    protected $fillable = [
        'chat_session_id',
        'user_id',
        'user_query',
        'ai_response',
        'extracted_insights',
        'was_helpful',
        'feedback_score',
        'correction',
        'added_to_knowledge_base',
        'knowledge_base_id',
    ];

    protected $casts = [
        'extracted_insights' => 'array',
        'was_helpful' => 'boolean',
        'feedback_score' => 'integer',
        'added_to_knowledge_base' => 'boolean',
    ];

    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(AiChatSession::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function knowledgeBase(): BelongsTo
    {
        return $this->belongsTo(AiKnowledgeBase::class);
    }

    /**
     * Extract insights from conversation
     */
    public function extractInsights(): array
    {
        $insights = [];

        // Check if user query contains technical terms
        if (preg_match_all('/\b(CVE-\d{4}-\d+|CWE-\d+|OWASP|SQL injection|XSS|CSRF)\b/i', $this->user_query, $matches)) {
            $insights['security_terms'] = array_unique($matches[0]);
        }

        // Check if response contains code
        if (preg_match('/```(\w+)?\n(.*?)```/s', $this->ai_response, $matches)) {
            $insights['code_language'] = $matches[1] ?? 'unknown';
            $insights['has_code_example'] = true;
        }

        // Check if response contains commands
        if (preg_match_all('/`([^`]+)`/', $this->ai_response, $matches)) {
            $insights['commands'] = array_unique($matches[1]);
        }

        return $insights;
    }

    /**
     * Mark as helpful and optionally add to knowledge base
     */
    public function markAsHelpful(int $score, bool $addToKB = false): void
    {
        $this->update([
            'was_helpful' => true,
            'feedback_score' => $score,
        ]);

        if ($addToKB && $score >= 4) {
            $this->addToKnowledgeBase();
        }
    }

    /**
     * Add this interaction to knowledge base
     */
    protected function addToKnowledgeBase(): void
    {
        if ($this->added_to_knowledge_base) {
            return;
        }

        $insights = $this->extractInsights();

        $kb = AiKnowledgeBase::create([
            'category' => $insights['category'] ?? 'general',
            'topic' => substr($this->user_query, 0, 200),
            'content' => $this->ai_response,
            'context' => "Learned from user interaction",
            'examples' => $insights['code_language'] ?? null ? ['language' => $insights['code_language']] : null,
            'tags' => $insights['security_terms'] ?? [],
            'relevance_score' => $this->feedback_score ?? 3.0,
            'source' => 'user_interaction',
            'created_by' => $this->user_id,
        ]);

        $this->update([
            'added_to_knowledge_base' => true,
            'knowledge_base_id' => $kb->id,
            'extracted_insights' => $insights,
        ]);
    }
}
