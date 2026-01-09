<?php

namespace App\Services\AgentAi;

use App\Models\Article;
use App\Models\CyberSecurityService;
use App\Models\Ebook;
use App\Models\Product;

class ResourceResolver
{
    /**
     * Resolve platform resources based on intent and search terms
     */
    public function resolve(string $scope, string $intent, string $prompt): array
    {
        $type = match ($intent) {
            'product' => 'product',
            'service' => 'service',
            'ebook' => 'ebook',
            'article' => 'article',
            default => 'none',
        };

        if ($type === 'none') {
            return ['none', collect()];
        }

        $search = mb_strtolower($prompt);
        $isGeneralRecommendation = str_contains($search, 'rekomendasi') || str_contains($search, 'saran') || str_contains($search, 'apa saja') || str_contains($search, 'list');

        return match ($type) {
            'product' => [
                $type, 
                Product::where('is_active', true)
                    ->when(!$isGeneralRecommendation, function($q) use ($search) {
                        return $q->where(fn($sq) => $sq->where('name', 'LIKE', "%{$search}%")->orWhere('summary', 'LIKE', "%{$search}%"));
                    })
                    ->orderByDesc('created_at')
                    ->limit(3)->get()
            ],
            'service' => [
                $type, 
                CyberSecurityService::where('is_active', true)
                    ->when(!$isGeneralRecommendation, function($q) use ($search) {
                        return $q->where(fn($sq) => $sq->where('name', 'LIKE', "%{$search}%")->orWhere('summary', 'LIKE', "%{$search}%"));
                    })
                    ->orderByDesc('created_at')
                    ->limit(3)->get()
            ],
            'ebook' => [
                $type, 
                Ebook::where('is_active', true)
                    ->when(!$isGeneralRecommendation, function($q) use ($search) {
                        return $q->where(fn($sq) => $sq->where('title', 'LIKE', "%{$search}%")->orWhere('summary', 'LIKE', "%{$search}%"));
                    })
                    ->orderByDesc('created_at')
                    ->limit(4)->get()
            ],
            'article' => [
                $type, 
                Article::where('is_published', true)
                    ->when(!$isGeneralRecommendation, function($q) use ($search) {
                        return $q->where(fn($sq) => $sq->where('title', 'LIKE', "%{$search}%")->orWhere('content', 'LIKE', "%{$search}%"));
                    })
                    ->orderByDesc('created_at')
                    ->limit(3)->get()
            ],
        };
    }
}
