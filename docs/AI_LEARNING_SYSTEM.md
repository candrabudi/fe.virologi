# 🧠 AI Learning System - Complete Guide

## 📚 Table of Contents
1. [Overview](#overview)
2. [Learning Methods](#learning-methods)
3. [Architecture](#architecture)
4. [Implementation Guide](#implementation-guide)
5. [Best Practices](#best-practices)
6. [Advanced Features](#advanced-features)

---

## 🎯 Overview

Sistem AI Learning ini mengimplementasikan **Continuous Learning** dengan beberapa metode:

### ✅ **Metode Learning yang Digunakan:**

1. **RAG (Retrieval Augmented Generation)** 🔍
   - AI mengambil knowledge dari database sebelum menjawab
   - Mengurangi hallucination
   - Selalu up-to-date dengan informasi terbaru

2. **Feedback Loop Learning** 🔄
   - Belajar dari rating user (1-5 stars)
   - Menyimpan jawaban yang helpful ke knowledge base
   - Menggunakan correction dari user untuk improve

3. **Automatic Insight Extraction** 🤖
   - Extract security terms (CVE, CWE, OWASP)
   - Identify code examples & commands
   - Categorize topics automatically

4. **Prompt Engineering dengan Database** 📊
   - System prompt customizable via database
   - Dynamic prompt building based on context
   - Priority-based prompt chaining

5. **Usage-Based Relevance** 📈
   - Knowledge yang sering digunakan = lebih relevan
   - Auto-ranking based on usage count
   - Decay old/unused knowledge

---

## 🏗️ Learning Methods - Deep Dive

### 1. **RAG (Retrieval Augmented Generation)**

**Cara Kerja:**
```
User Query → Extract Keywords → Search Knowledge Base → 
Inject Relevant Knowledge into Prompt → Send to GPT-5.2 → Response
```

**Keunggulan:**
- ✅ No need to fine-tune model
- ✅ Real-time knowledge updates
- ✅ Cost-effective
- ✅ Transparent (bisa lihat knowledge yang digunakan)

**Implementasi:**
```php
// Automatic RAG in AiLearningService
$relevantKnowledge = $this->getRelevantKnowledge($userQuery);
$dynamicPrompt = $basePrompt . "\n\n" . $relevantKnowledge;
```

---

### 2. **Feedback Loop Learning**

**Cara Kerja:**
```
AI Response → User Feedback (Rating + Comment) → 
If Rating >= 4 → Add to Knowledge Base → 
Future queries use this knowledge
```

**Implementasi:**
```php
// User rates AI response
$learningSession->markAsHelpful(
    score: 5,
    addToKB: true  // Auto-add if score >= 4
);

// Knowledge base updated automatically
// Next similar query will use this knowledge
```

**Feedback Types:**
- 👍 **Helpful** (score 4-5) → Add to KB
- 👎 **Not Helpful** (score 1-2) → Mark for review
- ✏️ **Correction** → Create improved KB entry
- ⭐ **Excellent** (score 5) → High priority KB entry

---

### 3. **Automatic Insight Extraction**

**Cara Kerja:**
AI automatically extracts valuable information from conversations:

```php
// Auto-extract from conversation
$insights = [
    'security_terms' => ['CVE-2024-1234', 'SQL Injection', 'OWASP Top 10'],
    'code_language' => 'php',
    'commands' => ['nmap -sV', 'sqlmap -u'],
    'tools_mentioned' => ['Burp Suite', 'Metasploit'],
    'category' => 'web_security'
];
```

**Extracted Data:**
- Security terms (CVE, CWE, OWASP)
- Programming languages
- Commands & tools
- Code snippets
- References & links

---

### 4. **Dynamic Prompt Building**

**Cara Kerja:**
```
Base Prompt (from code) +
Custom Prompts (from ai_system_prompts table) +
Relevant Knowledge (from ai_knowledge_base) +
Conversation Context (recent messages) +
Behavior Rules (from ai_behavior_rules) =
FINAL DYNAMIC PROMPT
```

**Example:**
```sql
-- Customize AI behavior via database
INSERT INTO ai_system_prompts (name, base_prompt, personality_traits) VALUES
('cybersecurity_expert', 
 'You are a cybersecurity expert...',
 '{"tone": "professional", "expertise_level": "senior", "response_style": "structured"}');

-- Add custom rules
INSERT INTO ai_behavior_rules (rule_name, trigger_condition, action) VALUES
('code_generation_rule',
 'user asks for code example',
 'Always provide secure code with comments explaining security measures');
```

---

### 5. **Usage-Based Relevance Scoring**

**Cara Kerja:**
```
Knowledge Entry Created → relevance_score = 3.0
User rates 5 stars → relevance_score = 5.0
Used 100 times → usage_count = 100
Not used for 6 months → relevance_score -= 0.5 (decay)
```

**Scoring Algorithm:**
```php
relevance_score = 
    (user_rating * 0.4) +
    (usage_frequency * 0.3) +
    (recency * 0.2) +
    (source_credibility * 0.1)

// Higher score = higher priority in RAG
```

---

## 🚀 Implementation Guide

### Step 1: Run Migration
```bash
php artisan migrate
```

### Step 2: Seed Initial Knowledge Base
```bash
php artisan db:seed --class=AiKnowledgeBaseSeeder
```

### Step 3: Configure System Prompts
```sql
INSERT INTO ai_system_prompts (name, version, base_prompt, is_active, priority) VALUES
('cybersecurity_core', '1.0', 'You are Virologi AI Security Expert...', 1, 100),
('code_reviewer', '1.0', 'When reviewing code, focus on security vulnerabilities...', 1, 90),
('threat_analyzer', '1.0', 'When analyzing threats, use CIA triad framework...', 1, 80);
```

### Step 4: Enable Learning in AgentAiService

Update `AgentAiService` to use `AiLearningService`:

```php
use App\Services\AgentAi\AiLearningService;

class AgentAiService
{
    public function __construct(
        private readonly AiLearningService $learningService,
        // ... other dependencies
    ) {}

    public function handleMessage(int $userId, string $promptRaw, ?string $sessionToken = null): array
    {
        // Build dynamic prompt with learned knowledge
        $dynamicPrompt = $this->learningService->buildDynamicPrompt(
            $basePrompt,
            $promptRaw,
            $session
        );

        // Send to LLM with enhanced prompt
        [$assistant, $usage] = $this->llm->chat($session, $setting, $dynamicPrompt);

        // Learn from this interaction
        $learningSession = $this->learningService->learnFromInteraction(
            $session->id,
            $userId,
            $promptRaw,
            $assistant
        );

        return [$sessionToken, $assistant, 200, $meta];
    }
}
```

### Step 5: Add Feedback API Endpoints

```php
// routes/web.php
Route::post('/api/ai/feedback/{message}', [AgentAiController::class, 'submitFeedback']);
Route::post('/api/ai/correct/{message}', [AgentAiController::class, 'submitCorrection']);
```

```php
// AgentAiController.php
public function submitFeedback(Request $request, AiChatMessage $message)
{
    $validated = $request->validate([
        'was_helpful' => 'required|boolean',
        'score' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    $learningSession = AiLearningSession::where('chat_session_id', $message->session_id)
        ->where('ai_response', $message->content)
        ->first();

    if ($learningSession) {
        app(AiLearningService::class)->processFeedback(
            $learningSession,
            $validated['was_helpful'],
            $validated['score']
        );
    }

    return response()->json(['success' => true]);
}
```

---

## 💡 Best Practices

### 1. **Knowledge Quality Control**

```php
// Review before adding to KB
if ($feedbackScore >= 4 && $userIsExpert) {
    $knowledge->update(['is_verified' => true]);
}

// Periodic review of low-scoring knowledge
AiKnowledgeBase::where('relevance_score', '<', 2.0)
    ->where('usage_count', '<', 5)
    ->delete(); // Remove low-quality entries
```

### 2. **Prevent Knowledge Pollution**

```php
// Deduplicate similar knowledge
$existing = AiKnowledgeBase::whereFullText(['topic', 'content'], $newTopic)
    ->where('similarity_score', '>', 0.8)
    ->first();

if ($existing) {
    // Merge instead of create new
    $existing->increment('usage_count');
} else {
    // Create new entry
}
```

### 3. **Continuous Improvement Cron Job**

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Auto-learn from quality interactions daily
    $schedule->call(function () {
        $learned = app(AiLearningService::class)->autoLearnFromQualityInteractions();
        \Log::info("Auto-learned from {$learned} interactions");
    })->daily();

    // Decay old knowledge monthly
    $schedule->call(function () {
        AiKnowledgeBase::where('last_used_at', '<', now()->subMonths(6))
            ->decrement('relevance_score', 0.5);
    })->monthly();
}
```

---

## 🔬 Advanced Features

### 1. **Semantic Search with Embeddings**

```php
// Generate embedding for knowledge
use OpenAI\Laravel\Facades\OpenAI;

$embedding = OpenAI::embeddings()->create([
    'model' => 'text-embedding-3-small',
    'input' => $knowledge->content,
]);

$knowledge->update([
    'embedding' => json_encode($embedding->embeddings[0]->embedding)
]);

// Search by semantic similarity
$queryEmbedding = OpenAI::embeddings()->create([
    'model' => 'text-embedding-3-small',
    'input' => $userQuery,
])->embeddings[0]->embedding;

// Calculate cosine similarity
$similar = AiKnowledgeBase::all()->map(function($kb) use ($queryEmbedding) {
    $similarity = $this->cosineSimilarity(
        json_decode($kb->embedding),
        $queryEmbedding
    );
    return ['knowledge' => $kb, 'similarity' => $similarity];
})->sortByDesc('similarity')->take(5);
```

### 2. **A/B Testing Different Prompts**

```php
// Test which prompt performs better
$promptA = AiSystemPrompt::find(1);
$promptB = AiSystemPrompt::find(2);

// Randomly assign users
$prompt = rand(0, 1) ? $promptA : $promptB;

// Track performance
AiPerformanceMetrics::create([
    'prompt_id' => $prompt->id,
    'user_satisfaction_score' => $feedbackScore,
]);
```

### 3. **Expert Review Dashboard**

Create admin dashboard to:
- Review unverified knowledge entries
- Approve/reject user corrections
- Monitor AI performance metrics
- Manually add high-quality knowledge

---

## 📊 Monitoring & Analytics

### Key Metrics to Track:

1. **Learning Rate**
   - New knowledge entries per day
   - Feedback submission rate
   - Knowledge base growth

2. **Quality Metrics**
   - Average feedback score
   - Percentage of helpful responses
   - Knowledge verification rate

3. **Usage Metrics**
   - Most used knowledge topics
   - RAG hit rate (how often KB is used)
   - Response time impact

4. **Improvement Metrics**
   - Before/after feedback scores
   - User satisfaction trend
   - Knowledge decay rate

---

## 🎓 Summary

**Metode Terbaik untuk AI Learning:**

1. ✅ **RAG (Retrieval Augmented Generation)** - Core method
2. ✅ **Feedback Loop** - User-driven improvement
3. ✅ **Automatic Extraction** - Passive learning
4. ✅ **Dynamic Prompts** - Customizable behavior
5. ✅ **Usage-Based Ranking** - Self-optimization

**Keunggulan Sistem Ini:**
- 🚀 No fine-tuning needed (cost-effective)
- 🔄 Continuous improvement
- 📊 Measurable results
- 🎯 Domain-specific expertise
- 🔒 Security-focused
- 💡 Transparent & explainable

**Next Steps:**
1. Run migration
2. Seed initial knowledge
3. Enable feedback collection
4. Monitor metrics
5. Iterate & improve

---

**Created by**: Virologi AI Team
**Last Updated**: 2026-01-09
