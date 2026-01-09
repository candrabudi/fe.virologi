<?php

namespace App\Services\AgentAi;

use App\Models\AiKnowledgeBase;
use App\Models\AiSystemPrompt;
use App\Models\AiLearningSession;
use App\Models\AiChatSession;
use App\Models\AiSetting;
use App\Models\Article;
use App\Models\CyberSecurityService;
use App\Models\Ebook;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

/**
 * AI Learning Service - Handles continuous learning and knowledge management
 */
class AiLearningService
{
    protected $llm;
    protected $metricService;

    public function __construct(LlmClient $llm, AiMetricService $metricService)
    {
        $this->llm = $llm;
        $this->metricService = $metricService;
    }
    /**
     * Build dynamic system prompt with learned knowledge
     */
    public function buildDynamicPrompt(string $basePrompt, string $userQuery, ?AiChatSession $session = null): string
    {
        // 1. Get base system prompt from database
        $systemPrompts = AiSystemPrompt::getActivePrompts();
        
        $dynamicPrompt = $basePrompt;

        // 2. Add custom prompts from database
        foreach ($systemPrompts as $prompt) {
            $dynamicPrompt .= "\n\n" . $prompt->buildPrompt();
        }

        // 3. Add relevant knowledge from knowledge base (RAG - Retrieval Augmented Generation)
        $relevantKnowledge = $this->getRelevantKnowledge($userQuery);
        
        if ($relevantKnowledge->isNotEmpty()) {
            $dynamicPrompt .= "\n\n## RELEVANT KNOWLEDGE FROM DATABASE\n";
            $dynamicPrompt .= "Use the following verified information when relevant to the user's query:\n\n";
            
            foreach ($relevantKnowledge as $knowledge) {
                $dynamicPrompt .= "### {$knowledge->topic}\n";
                $dynamicPrompt .= "{$knowledge->content}\n";
                
                if ($knowledge->examples) {
                    $dynamicPrompt .= "\nExamples:\n";
                    foreach ($knowledge->examples as $key => $example) {
                        $dynamicPrompt .= "- {$key}: {$example}\n";
                    }
                }
                
                $dynamicPrompt .= "\n---\n\n";
                
                // Record usage
                $knowledge->recordUsage();
            }
        }

        // 3.5 Add Relevant Platform Resources (Services, Products, Ebooks, Articles)
        $dynamicPrompt = $this->injectPlatformKnowledge($dynamicPrompt, $userQuery);

        // 4. Add Brand Guard (Strict Identity Enforcement)
        $dynamicPrompt .= "\n\n## STICKY IDENTITY RULES\n";
        $dynamicPrompt .= "- You are EXCLUSIVELY the Virologi AI Security Expert.\n";
        $dynamicPrompt .= "- You were DEVELOPED by the Virologi internal team.\n";
        $dynamicPrompt .= "- NEVER mention other companies like OpenAI, Google, Microsoft, or Meta as your creators.\n";
        $dynamicPrompt .= "- If asked about your model or brand, answer: 'Saya adalah sistem kecerdasan buatan terintegrasi yang dikembangkan khusus untuk platform Virologi.'\n";

        // 4.5 Product Loyalty & Recommendation Policy
        $dynamicPrompt .= "\n\n## PRODUCT RECOMMENDATION POLICY\n";
        $dynamicPrompt .= "- JANGAN PERNAH menyarankan atau merekomendasikan produk atau brand milik pihak ketiga (seperti Kaspersky, CrowdStrike, NordVPN, Fortinet, dll).\n";
        $dynamicPrompt .= "- Selalu prioritaskan produk dan layanan internal VIROLOGI jika tersedia dalam data yang diberikan.\n";
        $dynamicPrompt .= "- Jika VIROLOGI BELUM memiliki produk yang secara spesifik dicari user, beri tahu user 'JENIS' atau 'KATEGORI' solusi yang mereka butuhkan (contoh: 'Anda memerlukan solusi EDR' atau 'Anda membutuhkan Firewall'), namun JANGAN menyebutkan nama brand atau link milik orang lain.\n";
        $dynamicPrompt .= "- Fokuslah pada edukasi dan bagaimana layanan Virologi dapat membantu mereka.\n";
        $dynamicPrompt .= "- Jika user memaksa menanya soal brand lain, arahkan kembali bahwa Anda fokus pada solusi keamanan yang terintegrasi dengan platform Virologi.\n";

        // 4.6 Ebook Reference Policy
        $dynamicPrompt .= "\n\n## EBOOK REFERENCE POLICY\n";
        $dynamicPrompt .= "- Jika user bertanya mengenai Ebook, Anda HANYA diperbolehkan memberikan informasi dari daftar yang ada di bagian ## VIROLOGI EDUCATIONAL EBOOKS.\n";
        $dynamicPrompt .= "- Jika Ebook yang spesifik dicari user TIDAK ADA dalam daftar data kami, Anda WAJIB menjawab bahwa Ebook tersebut belum tersedia atau tidak ditemukan di saat ini.\n";
        $dynamicPrompt .= "- JANGAN menyarankan ebook dari situs luar atau brand lain.\n";
        $dynamicPrompt .= "- Selalu gunakan judul dan penulis yang tertera di database kita.\n";

        // 5. Add conversation context if available
        if ($session) {
            $recentMessages = $session->messages()
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->reverse();
            
            if ($recentMessages->isNotEmpty()) {
                $dynamicPrompt .= "\n\n## RECENT CONVERSATION CONTEXT\n";
                foreach ($recentMessages as $msg) {
                    $dynamicPrompt .= "{$msg->role}: {$msg->content}\n";
                }
            }
        }

        return $dynamicPrompt;
    }

    /**
     * Get relevant knowledge from knowledge base using semantic search
     */
    protected function getRelevantKnowledge(string $query, int $limit = 3)
    {
        // Extract keywords from query
        $keywords = $this->extractKeywords($query);
        
        if (empty($keywords)) {
            return collect();
        }

        // Search knowledge base
        return AiKnowledgeBase::whereFullText(['topic', 'content'], implode(' ', $keywords))
            ->where('relevance_score', '>=', 3.0)
            ->orderByRaw("FIELD(source, 'user_correction') DESC")
            ->orderByDesc('relevance_score')
            ->orderByDesc('usage_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Extract keywords from user query
     */
    protected function extractKeywords(string $query): array
    {
        // Remove common words
        $stopWords = ['apa', 'adalah', 'yang', 'untuk', 'dari', 'di', 'ke', 'dengan', 'pada', 'how', 'what', 'is', 'the', 'to', 'from', 'in', 'at', 'with'];
        
        $words = preg_split('/\s+/', strtolower($query));
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 3 && !in_array($word, $stopWords);
        });

        return array_values($keywords);
    }

    /**
     * Learn from user interaction
     */
    public function learnFromInteraction(
        int $chatSessionId,
        int $userId,
        string $userQuery,
        string $aiResponse
    ): AiLearningSession {
        $learningSession = AiLearningSession::create([
            'chat_session_id' => $chatSessionId,
            'user_id' => $userId,
            'user_query' => $userQuery,
            'ai_response' => $aiResponse,
        ]);

        // Auto-extract insights
        $insights = $learningSession->extractInsights();
        $learningSession->update(['extracted_insights' => $insights]);

        return $learningSession;
    }

    /**
     * Process user feedback and improve knowledge base
     */
    public function processFeedback(
        AiLearningSession $learningSession,
        bool $wasHelpful,
        int $score,
        ?string $correction = null
    ): void {
        $learningSession->update([
            'was_helpful' => $wasHelpful,
            'feedback_score' => $score,
            'correction' => $correction,
        ]);

        // If highly rated, add to knowledge base
        if ($wasHelpful && $score >= 4) {
            $learningSession->markAsHelpful($score, true);
        }

        // If user provided correction, create improved knowledge entry
        if ($correction) {
            $this->createCorrectedKnowledge($learningSession, $correction);
        }

        // Record metrics
        $this->metricService->recordFeedback($score);
    }

    /**
     * Create knowledge entry from user correction
     */
    protected function createCorrectedKnowledge(AiLearningSession $session, string $correction): void
    {
        AiKnowledgeBase::create([
            'category' => 'user_correction',
            'topic' => substr($session->user_query, 0, 200),
            'content' => $correction,
            'context' => "User-provided correction for: " . substr($session->ai_response, 0, 100),
            'relevance_score' => 4.5, // High score for user corrections
            'source' => 'user_correction',
            'created_by' => $session->user_id,
        ]);
    }

    /**
     * Auto-learn from high-quality interactions (batch processing)
     */
    public function autoLearnFromQualityInteractions(): int
    {
        $qualityInteractions = AiLearningSession::where('was_helpful', true)
            ->where('feedback_score', '>=', 4)
            ->where('added_to_knowledge_base', false)
            ->limit(50)
            ->get();

        $learned = 0;

        foreach ($qualityInteractions as $interaction) {
            try {
                $interaction->markAsHelpful($interaction->feedback_score, true);
                $learned++;
            } catch (\Exception $e) {
                \Log::error("Failed to learn from interaction {$interaction->id}: " . $e->getMessage());
            }
        }

        return $learned;
    }

    /**
     * AI Mentorship: Get GPT to teach our AI how to be professional, friendly, and expert
     */
    public function receiveMentorship(int $count = 5): array
    {
        $learnedData = [];
        $settings = AiSetting::where('is_active', true)->first();
        if (!$settings) return [];

        $prompt = <<<PROMPT
You are a Master AI Trainer. Your task is to generate $count high-quality "Gold Standard" training pairs for a specialized cybersecurity AI named 'Virologi AI Security Expert'.

Each training pair must include:
1. A realistic user question about cybersecurity or software security.
2. An 'Ideal Answer' that is:
   - Factually correct and expert-level.
   - Exceptionally friendly and professional.
   - Clearly branded as 'Virologi' (never mention OpenAI/GPT).
   - Structured with markdown (headings, lists).

Format: JSON only.
Structure:
[
  {
    "category": "technical/etiquette/problem_solving",
    "question": "The user query",
    "ideal_answer": "The perfect response",
    "context": "Context for this training",
    "metadata": {"tone": "friendly_professional", "difficulty": "advanced"}
  }
]
Only return valid JSON.
PROMPT;

        try {
            $response = $this->llm->research($settings, $prompt, 3000);
            $batch = json_decode($this->cleanJsonResponse($response), true);

            if (is_array($batch)) {
                foreach ($batch as $item) {
                    $entry = AiTrainingData::updateOrCreate(
                        ['question' => $item['question']],
                        [
                            'category' => $item['category'] ?? 'gpt_mentorship',
                            'ideal_answer' => $item['ideal_answer'],
                            'context' => $item['context'] ?? 'Generated via GPT Mentorship',
                            'metadata' => $item['metadata'] ?? [],
                            'is_approved' => true,
                        ]
                    );
                    $learnedData[] = $item['question'];
                }
            }
        } catch (\Exception $e) {
            Log::error("GPT Mentorship failed: " . $e->getMessage());
        }

        return $learnedData;
    }

    /**
     * Study and Synchronize existing Products into the AI's deep Knowledge Base
     */
    public function syncProductsToKnowledge(): int
    {
        $products = Product::where('is_active', true)->where('is_ai_visible', true)->get();
        $synced = 0;

        foreach ($products as $product) {
            $topic = "Produk Virologi: {$product->name}";
            
            // Format deep knowledge about the product
            $content = "{$product->name} adalah produk {$product->product_type} dalam domain {$product->ai_domain}. ";
            $content .= "Detail: {$product->summary}\n";
            $content .= "Konten utama: " . strip_tags($product->content);

            $examples = [
                'use_cases' => implode(', ', $product->ai_use_cases ?? []),
                'target_level' => $product->ai_level ?? 'all_levels',
                'cta' => "Silakan cek di: {$product->cta_url} ({$product->cta_label})"
            ];

            AiKnowledgeBase::updateOrCreate(
                ['topic' => $topic],
                [
                    'category' => 'product_knowledge',
                    'content' => $content,
                    'context' => "Gunakan informasi ini saat user bertanya tentang produk, solusi {$product->ai_domain}, atau butuh bantuan di level {$product->ai_level}.",
                    'examples' => $examples,
                    'tags' => array_merge(['product', $product->ai_domain], $product->ai_keywords ?? []),
                    'relevance_score' => 5.0, // Maximum priority for our own products
                    'source' => 'product_sync',
                ]
            );

            $synced++;
        }

        return $synced;
    }

    public function syncServicesToKnowledge(): int
    {
        $services = CyberSecurityService::where('is_active', true)->where('is_ai_visible', true)->get();
        $synced = 0;

        foreach ($services as $service) {
            $topic = "Layanan Virologi: {$service->name}";
            
            $content = "{$service->name} adalah layanan profesional Virologi dalam kategori {$service->category}. ";
            $content .= "Deskripsi: {$service->summary}\n";
            $content .= "Scope Pekerjaan: " . implode(', ', $service->service_scope ?? []) . "\n";
            $content .= "Deliverables: " . implode(', ', $service->deliverables ?? []) . "\n";
            $content .= "Target Audience: " . implode(', ', $service->target_audience ?? []);

            $examples = [
                'cta' => "Hubungi kami di: {$service->cta_url} ({$service->cta_label})"
            ];

            AiKnowledgeBase::updateOrCreate(
                ['topic' => $topic],
                [
                    'category' => 'service_knowledge',
                    'content' => $content,
                    'context' => "Gunakan informasi ini saat user membutuhkan jasa profesional, konsultasi keamanan, atau bantuan teknis di domain {$service->ai_domain}.",
                    'examples' => $examples,
                    'tags' => array_merge(['service', $service->ai_domain, $service->category], $service->ai_keywords ?? []),
                    'relevance_score' => 5.0,
                    'source' => 'service_sync',
                ]
            );

            $synced++;
        }

        return $synced;
    }

    /**
     * Autonomous Discovery: Find gaps and learn new things
     */
    public function discoverAndLearn(int $limit = 1): array
    {
        // 1. Sync internal product & service knowledge first
        $this->syncProductsToKnowledge();
        $this->syncServicesToKnowledge();

        // 2. Identify what we should learn next (external gaps)
        $settings = AiSetting::where('is_active', true)->first();
        if (!$settings) {
            \Log::warning("No active AI settings found for autonomous discovery.");
            return [];
        }
        $topicsToLearn = $this->identifyLeaningGaps($settings);
        $learnedTopics = [];

        foreach (array_slice($topicsToLearn, 0, $limit) as $topic) {
            try {
                $researchData = $this->autonomousResearch($settings, $topic);
                if ($researchData) {
                    $this->storeLearnedKnowledge($topic, $researchData);
                    $learnedTopics[] = $topic;
                }
            } catch (\Exception $e) {
                Log::error("Autonomous research failed for topic '{$topic}': " . $e->getMessage());
            }
        }

        return $learnedTopics;
    }

    /**
     * Identify missing knowledge or emerging topics within allowed domains
     */
    protected function identifyLeaningGaps(AiSetting $settings): array
    {
        // Get existing topics to avoid duplicates
        $existingTopics = AiKnowledgeBase::pluck('topic')->toArray();
        $topicList = implode(', ', array_slice($existingTopics, 0, 100));

        $prompt = <<<PROMPT
As Virologi AI Security Expert, analyze these existing knowledge topics: [{$topicList}].

TASK:
Identify 5 NEW, ADVANCED, or EMERGING topics that are NOT in the list.

STRICT DOMAIN LIMITS:
You are ONLY allowed to suggest topics within these 3 domains:
1. CYBERSECURITY (Offensive, Defensive, Compliance, Cloud Sec, etc.)
2. PROGRAMMING & SOFTWARE ENGINEERING (Secure Coding, Architecture, Frameworks, DevOps)
3. THE IT WORLD (Networking, Infrastructure, Emerging Tech like AI/Web3/Computing)

REJECTION CRITERIA:
- Do NOT suggest general trivia, cooking, sports, entertainment, or non-IT/Security topics.
- Topics must be professional and technical.

Return ONLY a comma-separated list of topics.
PROMPT;

        $response = $this->llm->research($settings, $prompt, 200);
        return array_map('trim', explode(',', $response));
    }

    /**
     * Deep-dive into a specific topic with domain enforcement
     */
    protected function autonomousResearch(AiSetting $settings, string $topic): ?array
    {
        $prompt = <<<PROMPT
Topic: {$topic}
Task: Provide a detailed expert knowledge entry for our Knowledge Base.

STRICT RULE: If the topic is NOT related to Cybersecurity, Programming, or IT, return an empty JSON object {}.

Domain Context:
- If IT/Programming: Focus on best practices and security implications.
- If Security: Focus on technical implementation and mitigation.

Format: JSON only.
Structure:
{
  "category": "emerging_tech / web_security / app_sec / programming_sec / infra / devops",
  "topic": "{$topic}",
  "content": "Professional explanation of 3-5 paragraphs",
  "context": "When to use this information",
  "examples": {"setup": "...", "implementation": "..."},
  "references": {"link_name": "URL"},
  "tags": ["tag1", "tag2"]
}
Only return valid JSON. Do not include markdown formatting.
PROMPT;

        $response = $this->llm->research($settings, $prompt, 1800);
        $data = json_decode($this->cleanJsonResponse($response), true);

        return (is_array($data) && !empty($data)) ? $data : null;
    }

    /**
     * Clean LLM response to ensure valid JSON
     */
    protected function cleanJsonResponse(string $json): string
    {
        $json = preg_replace('/^```json\s*/', '', $json);
        $json = preg_replace('/^```\s*/', '', $json);
        $json = preg_replace('/\s*```$/', '', $json);
        return trim($json);
    }

    /**
     * Save researched data to Knowledge Base
     */
    protected function storeLearnedKnowledge(string $topic, array $data): void
    {
        AiKnowledgeBase::updateOrCreate(
            ['topic' => $topic],
            [
                'category' => $data['category'] ?? 'autonomous_discovery',
                'content' => $data['content'] ?? '',
                'context' => $data['context'] ?? null,
                'examples' => $data['examples'] ?? null,
                'references' => $data['references'] ?? null,
                'tags' => $data['tags'] ?? [],
                'relevance_score' => 4.0, // Initial score for automated research
                'source' => 'autonomous_discovery',
            ]
        );

        $this->metricService->recordNewLearning();
    }

    /**
     * Inject relevant data from Services, Products, Ebooks, and Articles
     */
    protected function injectPlatformKnowledge(string $prompt, string $query): string
    {
        $keywords = $this->extractKeywords($query);
        if (empty($keywords)) return $prompt;
        
        $search = implode(' ', $keywords);

        // a. Find Services
        $services = CyberSecurityService::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('summary', 'LIKE', "%{$search}%");
            })
            ->limit(2)->get();

        if ($services->isNotEmpty()) {
            $prompt .= "\n\n## VIROLOGI CYBER SECURITY SERVICES\n";
            $prompt .= "Kami memiliki layanan profesional berikut yang relevan:\n";
            foreach ($services as $s) {
                $prompt .= "- **{$s->name}**: {$s->summary} (Scope: " . implode(', ', $s->service_scope ?? []) . ")\n";
            }
        }

        // b. Find Products
        $products = Product::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('summary', 'LIKE', "%{$search}%");
            })
            ->limit(2)->get();

        if ($products->isNotEmpty()) {
            $prompt .= "\n\n## VIROLOGI PRODUCTS\n";
            $prompt .= "Produk pendukung kami:\n";
            foreach ($products as $p) {
                $prompt .= "- **{$p->name}**: {$p->subtitle} - {$p->summary}\n";
            }
        }

        // c. Find Ebooks
        $isGeneralEbook = str_contains($search, 'rekomendasi') || str_contains($search, 'saran') || str_contains($search, 'apa saja');
        
        $ebooks = Ebook::where('is_active', true)
            ->when(!$isGeneralEbook, function($q) use ($search) {
                return $q->where(fn($sq) => $sq->where('title', 'LIKE', "%{$search}%")->orWhere('summary', 'LIKE', "%{$search}%"));
            })
            ->orderByDesc('created_at')
            ->limit(4)->get();

        if ($ebooks->isNotEmpty()) {
            $prompt .= "\n\n## VIROLOGI EDUCATIONAL EBOOKS\n";
            $prompt .= "Berikut adalah 4 Ebook terbaru kami yang direkomendasikan:\n";
            foreach ($ebooks as $e) {
                $prompt .= "- **{$e->title}**: {$e->summary} (Author: {$e->author})\n";
            }
        }

        // d. Find Articles (The AI learns from these)
        $articles = Article::where('is_published', true)
            ->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            })
            ->limit(3)->get();

        if ($articles->isNotEmpty()) {
            $prompt .= "\n\n## INSIGHT FROM VIROLOGI ARTICLES & BLOG\n";
            $prompt .= "Informasi tambahan dari publikasi terbaru kami:\n";
            foreach ($articles as $a) {
                $prompt .= "### {$a->title}\n" . substr(strip_tags($a->content), 0, 500) . "...\n\n";
            }
        }

        return $prompt;
    }

    /**
     * Get learning statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_knowledge_entries' => AiKnowledgeBase::count(),
            'total_learning_sessions' => AiLearningSession::count(),
            'helpful_interactions' => AiLearningSession::where('was_helpful', true)->count(),
            'average_feedback_score' => AiLearningSession::whereNotNull('feedback_score')->avg('feedback_score'),
            'knowledge_by_category' => AiKnowledgeBase::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category'),
            'top_topics' => AiKnowledgeBase::orderByDesc('usage_count')
                ->limit(10)
                ->pluck('topic', 'usage_count'),
            'autonomous_discoveries' => AiKnowledgeBase::where('source', 'autonomous_discovery')->count(),
        ];
    }
}
