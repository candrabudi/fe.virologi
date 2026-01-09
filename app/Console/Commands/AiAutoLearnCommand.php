<?php

namespace App\Console\Commands;

use App\Services\AgentAi\AiLearningService;
use Illuminate\Console\Command;

class AiAutoLearnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:autolearn {--limit=50 : Number of sessions to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically extracts knowledge from high-quality AI interactions';

    /**
     * Execute the console command.
     */
    public function handle(AiLearningService $learningService)
    {
        $this->info('Starting AI Auto-Learning process...');
        
        $limit = (int) $this->option('limit');
        $count = $learningService->autoLearnFromQualityInteractions($limit);

        if ($count > 0) {
            $this->success("Successfully learned {$count} new insights from recent interactions.");
        } else {
            $this->info('No high-quality interactions found to learn from at this time.');
        }

        return Command::SUCCESS;
    }

    /**
     * Print success message (Compatibility helper)
     */
    private function success(string $message): void
    {
        $this->line("<info>SUCCESS</info> {$message}");
    }
}
