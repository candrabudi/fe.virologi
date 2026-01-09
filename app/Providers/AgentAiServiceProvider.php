<?php

namespace App\Providers;

use App\Services\AgentAi\AgentAiService;
use App\Services\AgentAi\BehaviorDecider;
use App\Services\AgentAi\IntentResolver;
use App\Services\AgentAi\LlmClient;
use App\Services\AgentAi\PromptNormalizer;
use App\Services\AgentAi\PromptResolverService;
use App\Services\AgentAi\ResourceResolver;
use App\Services\AgentAi\ScopeGate;
use App\Services\AgentAi\TitleGenerator;
use App\Services\AgentAi\AiLearningService;
use App\Services\AgentAi\AiMetricService;
use App\Services\AgentAi\AiLanguageNormalizerService;
use App\Services\AgentAi\AiLanguageTrainerService;
use Illuminate\Support\ServiceProvider;

class AgentAiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AiLanguageNormalizerService::class);
        $this->app->singleton(AiLanguageTrainerService::class);

        $this->app->singleton(PromptNormalizer::class);
        $this->app->singleton(ScopeGate::class);
        $this->app->singleton(IntentResolver::class);
        $this->app->singleton(BehaviorDecider::class);
        $this->app->singleton(ResourceResolver::class);
        $this->app->singleton(PromptResolverService::class);
        $this->app->singleton(AiLearningService::class);
        $this->app->singleton(AiMetricService::class);
        $this->app->singleton(LlmClient::class);
        $this->app->singleton(TitleGenerator::class);

        // Let Laravel auto-resolve AgentAiService constructor
        $this->app->singleton(AgentAiService::class);
    }
}
