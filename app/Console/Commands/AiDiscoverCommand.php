<?php

namespace App\Console\Commands;

use App\Services\AgentAi\AiLearningService;
use Illuminate\Console\Command;

class AiDiscoverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:discover {--limit=1 : Number of new topics to research}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Autonomous AI research: identifies gaps and learns new cybersecurity topics';

    /**
     * Execute the console command.
     */
    public function handle(AiLearningService $learningService)
    {
        $limit = (int) $this->option('limit');
        $this->info("AI is starting autonomous research for {$limit} new topic(s)...");
        
        $this->output->progressStart($limit);
        
        $learnedTopics = $learningService->discoverAndLearn($limit);
        
        $this->output->progressFinish();

        if (!empty($learnedTopics)) {
            $this->info("\nSUCCESS! AI has autonomously learned about:");
            foreach ($learnedTopics as $topic) {
                $this->line("- <info>{$topic}</info>");
            }
        } else {
            $this->warn("\nAI couldn't find new topics to learn or research failed.");
        }

        return Command::SUCCESS;
    }
}
