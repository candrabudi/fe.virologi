<?php

namespace App\Services\AgentAi;

use App\Models\AiPerformanceMetrics;
use Carbon\Carbon;

class AiMetricService
{
    /**
     * Record a summary of a single interaction for performance tracking
     */
    public function recordInteraction(bool $success, float $responseTimeMs, bool $kbHit): void
    {
        $today = Carbon::today()->toDateString();
        
        $metrics = AiPerformanceMetrics::firstOrCreate(
            ['metric_date' => $today],
            [
                'total_queries' => 0,
                'successful_responses' => 0,
                'failed_responses' => 0,
                'average_response_time' => 0,
                'knowledge_base_hits' => 0,
                'new_learnings' => 0,
            ]
        );

        $totalQueries = $metrics->total_queries + 1;
        
        // Calculate new average response time
        $currentAvg = (float) $metrics->average_response_time;
        $newAvg = (($currentAvg * $metrics->total_queries) + ($responseTimeMs / 1000)) / $totalQueries;

        $metrics->update([
            'total_queries' => $totalQueries,
            'successful_responses' => $metrics->successful_responses + ($success ? 1 : 0),
            'failed_responses' => $metrics->failed_responses + ($success ? 0 : 1),
            'average_response_time' => $newAvg,
            'knowledge_base_hits' => $metrics->knowledge_base_hits + ($kbHit ? 1 : 0),
        ]);
    }

    /**
     * Increment new learnings count
     */
    public function recordNewLearning(): void
    {
        $today = Carbon::today()->toDateString();
        $metrics = AiPerformanceMetrics::where('metric_date', $today)->first();
        
        if ($metrics) {
            $metrics->increment('new_learnings');
        }
    }

    /**
     * Record user feedback score
     */
    public function recordFeedback(int $score): void
    {
        $today = Carbon::today()->toDateString();
        
        $metrics = AiPerformanceMetrics::firstOrCreate(
            ['metric_date' => $today],
            [
                'total_queries' => 0,
                'successful_responses' => 0,
                'failed_responses' => 0,
                'average_response_time' => 0,
                'knowledge_base_hits' => 0,
                'new_learnings' => 0,
                'user_satisfaction_score' => 0,
            ]
        );

        $currentScore = (float) $metrics->user_satisfaction_score;
        // If it's the first score (0) and we have queries, we might want to start fresh or weigh it.
        // But simply: average it with previous scores? 
        // Problem: We don't store "total_feedbacks" count in this table.
        // We can approximate using successful_responses if we assume every success has feedback (which is false).
        // Since we don't have feedback_count, let's use a moving average or query `AiLearningSession` count if needed.
        // A simple approach for now:
        // (OldScore + NewScore) / 2 is BAD.
        
        // Better: Fetch total feedback count for today from DB to calculate properly.
        $feedbackCount = \App\Models\AiLearningSession::whereDate('created_at', $today)
            ->whereNotNull('feedback_score')
            ->count();
        
        // The count includes the one we just handled in AiLearningService? 
        // AiLearningService calls this after updating session, so Yes.
        
        if ($feedbackCount > 0) {
            $avgScore = \App\Models\AiLearningSession::whereDate('created_at', $today)
                ->whereNotNull('feedback_score')
                ->avg('feedback_score');
                
            $metrics->update(['user_satisfaction_score' => $avgScore]);
        } else {
             $metrics->update(['user_satisfaction_score' => $score]);
        }
    }
}
