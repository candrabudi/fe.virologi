<?php

namespace App\Services\AgentAi;

class AiLanguageNormalizerService
{
    public function __construct(private LanguageDetector $detector)
    {
    }

    /**
     * Normalize text, detect language, and extract unknown terms for learning.
     */
    public function normalize(string $text, string $scope = 'cybersecurity'): array
    {
        // 1. Security & Basic Cleaning
        $text = strip_tags(trim($text));
        
        // 2. Normalize characters
        $clean = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', mb_strtolower($text));
        $clean = trim(preg_replace('/\s+/u', ' ', $clean));

        $tokens = $clean === '' ? [] : explode(' ', $clean);
        
        // 3. Language Detection
        $language = $this->detector->detect($tokens);

        $normalized = $tokens;
        $unknown = [];

        // 4. Unknown Term Extraction (Basic heuristic: length >= 4)
        foreach ($tokens as $t) {
            if (mb_strlen($t) >= 4) {
                $unknown[] = $t;
            }
        }

        return [
            'original_text' => $text,
            'normalized_text' => implode(' ', $normalized),
            'language_code' => $language,
            'unknown_terms' => array_values(array_unique($unknown)),
        ];
    }
}
