<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiSystemPrompt extends Model
{
    protected $table = 'ai_system_prompts';

    protected $fillable = [
        'name',
        'version',
        'base_prompt',
        'personality_traits',
        'capabilities',
        'response_templates',
        'custom_rules',
        'scope_code',
        'code',
        'intent_code',
        'behavior',
        'resource_type',
        'content',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'personality_traits' => 'array',
        'capabilities' => 'array',
        'response_templates' => 'array',
        'custom_rules' => 'array',
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];
    /**
     * Get active prompts ordered by priority
     */
    public static function getActivePrompts()
    {
        return self::where('is_active', true)
            ->orderByDesc('priority')
            ->get();
    }

    /**
     * Build complete system prompt
     */
    public function buildPrompt(): string
    {
        $prompt = $this->base_prompt ?? $this->content;

        if ($this->personality_traits) {
            $prompt .= "\n\n## PERSONALITY TRAITS\n";
            foreach ($this->personality_traits as $key => $value) {
                $prompt .= "- {$key}: {$value}\n";
            }
        }

        if ($this->capabilities) {
            $prompt .= "\n\n## CAPABILITIES\n";
            $prompt .= "- " . implode("\n- ", $this->capabilities);
        }

        if ($this->custom_rules) {
            $prompt .= "\n\n## CUSTOM RULES\n";
            foreach ($this->custom_rules as $rule) {
                $prompt .= "- {$rule}\n";
            }
        }

        return $prompt;
    }
}
