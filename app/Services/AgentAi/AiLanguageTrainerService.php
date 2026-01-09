<?php

namespace App\Services\AgentAi;

class AiLanguageTrainerService
{
    /**
     * Placeholder for automatic language training.
     * Core learning logic has been migrated to AiLearningService.
     */
    public function learnAutomatically(
        array $unknownTerms,
        string $scopeCode,
        string $languageCode,
        int $intentConfidence,
        bool $validScope,
        ?int $userId = null,
        ?int $sessionId = null
    ): void {
        // Logic for language training is now handled via AiLearningService->learnFromInteraction().
        // This service is maintained for structural compatibility in the AgentAi workflow.
    }
}
