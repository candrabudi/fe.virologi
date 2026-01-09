<?php

namespace App\Services\AgentAi;

class IntentResolver
{
    /**
     * Resolve user intent based on keywords
     */
    public function resolve(string $prompt): object
    {
        $prompt = mb_strtolower($prompt);
        
        $intents = [
            'product' => ['produk', 'beli', 'harga', 'jual', 'bayar', 'product', 'buy', 'price'],
            'service' => ['layanan', 'service', 'jasa', 'audit', 'pentest', 'konsultasi', 'consultation'],
            'ebook' => ['ebook', 'buku', 'download', 'pdf', 'belajar', 'materi', 'read'],
            'article' => ['artikel', 'berita', 'blog', 'tulisan', 'post', 'news', 'article'],
            'security_analysis' => ['analisis', 'check', 'periksa', 'aman', 'bahaya', 'vulnerability', 'celah'],
        ];

        foreach ($intents as $code => $keywords) {
            foreach ($keywords as $word) {
                if (str_contains($prompt, $word)) {
                    return (object) [
                        'code' => $code,
                        'confidence' => 90,
                    ];
                }
            }
        }

        return (object) [
            'code' => 'general',
            'confidence' => 100,
        ];
    }
}
