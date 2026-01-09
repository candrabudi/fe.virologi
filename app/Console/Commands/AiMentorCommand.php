<?php

namespace App\Console\Commands;

use App\Services\AgentAi\AiLearningService;
use Illuminate\Console\Command;

class AiMentorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:mentor {--count=5 : Number of training pairs to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get GPT to mentor Virologi AI: generates high-quality, friendly, and professional training data';

    /**
     * Execute the console command.
     */
    public function handle(AiLearningService $learningService)
    {
        $count = (int) $this->option('count');
        $this->info("GPT is mentoring Virologi AI (Generating {$count} Gold Standard responses)...");
        
        $this->output->progressStart($count);
        
        $learnedData = $learningService->receiveMentorship($count);
        
        $this->output->progressFinish();

        if (!empty($learnedData)) {
            $this->info("\nSUCCESS! Virologi AI has learned new professional patterns:");
            foreach ($learnedData as $q) {
                $this->line("- <info>{$q}</info>");
            }
        } else {
            $this->warn("\nMentorship session failed. Check logs.");
        }

        return Command::SUCCESS;
    }
}
