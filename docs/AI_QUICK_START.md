# 🚀 AI Learning System - Quick Start Guide

## 📋 Prerequisites
- PHP 8.2+
- Laravel 11
- MySQL 8.0+
- OpenAI API Key (GPT-5.2)

---

## ⚡ Quick Setup (5 Minutes)

### Step 1: Run Migration
```bash
php artisan migrate
```

### Step 2: Seed Initial Knowledge Base
```bash
php artisan db:seed --class=AiKnowledgeBaseSeeder
```

### Step 3: Configure AI Settings in Database
```sql
UPDATE ai_settings SET
    model = 'gpt-5.2',
    temperature = 0.7,
    max_tokens = 2500
WHERE id = 1;
```

### Step 4: Test AI
Visit your chat interface and ask:
```
"Bagaimana cara mencegah SQL injection di Laravel?"
```

AI akan menggunakan knowledge dari database! ✅

---

## 🎯 How It Works

### 1. **User Asks Question**
```
User: "Gimana cara secure API dari brute force?"
```

### 2. **AI Searches Knowledge Base**
```php
// Automatic RAG (Retrieval Augmented Generation)
$relevantKnowledge = AiKnowledgeBase::search("brute force API");
// Returns: Rate limiting, account lockout, MFA, etc.
```

### 3. **AI Builds Dynamic Prompt**
```
Base Prompt (from code) +
System Prompts (from ai_system_prompts table) +
Relevant Knowledge (from ai_knowledge_base) +
Conversation History =
ENHANCED PROMPT
```

### 4. **AI Responds with Context**
```
AI: "🔴 Brute force attack memang serius! Mari kita setup defense berlapis:

🛡️ IMMEDIATE ACTIONS:
1. Rate Limiting ⚡
   [Code example from knowledge base]
2. Account Lockout 🔒
   [Best practices from knowledge base]
...
```

### 5. **User Gives Feedback**
```javascript
// User clicks thumbs up and rates 5 stars
fetch('/api/ai/feedback/' + messageId, {
    method: 'POST',
    body: JSON.stringify({
        was_helpful: true,
        score: 5,
        comment: 'Very helpful!'
    })
});
```

### 6. **AI Learns**
```php
// If score >= 4, automatically add to knowledge base
if ($score >= 4) {
    AiKnowledgeBase::create([
        'topic' => 'API Brute Force Defense',
        'content' => $aiResponse,
        'relevance_score' => 5.0,
        'source' => 'user_interaction'
    ]);
}
```

### 7. **Future Queries Benefit**
```
Next user asks similar question →
AI finds this knowledge in database →
Provides even better answer! 🚀
```

---

## 🔧 Customization via Database

### Add Custom System Prompt
```sql
INSERT INTO ai_system_prompts (name, base_prompt, personality_traits, is_active, priority) VALUES
('penetration_tester',
 'When analyzing security, think like a penetration tester. Identify attack vectors and exploitation paths.',
 '{"tone": "analytical", "focus": "offensive_security"}',
 1,
 95);
```

### Add Custom Behavior Rule
```sql
INSERT INTO ai_behavior_rules (rule_name, trigger_condition, action, priority, is_active) VALUES
('Code Testing Rule',
 'User requests code for security testing',
 'Provide working test code with explanation of what it tests and expected results',
 100,
 1);
```

### Add Knowledge Manually
```sql
INSERT INTO ai_knowledge_base (category, topic, content, examples, tags, relevance_score, source) VALUES
('cloud_security',
 'AWS S3 Bucket Security',
 'Best practices for securing S3 buckets: 1. Block public access by default, 2. Enable versioning, 3. Use bucket policies...',
 '{"aws_cli": "aws s3api put-public-access-block --bucket mybucket --public-access-block-configuration BlockPublicAcls=true"}',
 '["aws", "s3", "cloud-security", "storage"]',
 5.0,
 'manual');
```

---

## 📊 Monitor Learning Progress

### Check Knowledge Base Growth
```sql
SELECT 
    category,
    COUNT(*) as total_entries,
    AVG(relevance_score) as avg_score,
    SUM(usage_count) as total_usage
FROM ai_knowledge_base
GROUP BY category
ORDER BY total_usage DESC;
```

### Check User Satisfaction
```sql
SELECT 
    DATE(created_at) as date,
    AVG(feedback_score) as avg_score,
    COUNT(*) as total_feedback,
    SUM(CASE WHEN was_helpful = 1 THEN 1 ELSE 0 END) as helpful_count
FROM ai_learning_sessions
WHERE feedback_score IS NOT NULL
GROUP BY DATE(created_at)
ORDER BY date DESC
LIMIT 30;
```

### Top Performing Knowledge
```sql
SELECT 
    topic,
    usage_count,
    relevance_score,
    category,
    last_used_at
FROM ai_knowledge_base
ORDER BY usage_count DESC, relevance_score DESC
LIMIT 20;
```

---

## 🎨 Frontend Integration

### Add Feedback Buttons to Chat UI
```html
<div class="ai-message">
    <div class="message-content">{{ aiResponse }}</div>
    <div class="feedback-buttons">
        <button onclick="submitFeedback(messageId, true, 5)">
            👍 Helpful
        </button>
        <button onclick="submitFeedback(messageId, false, 2)">
            👎 Not Helpful
        </button>
        <button onclick="showCorrectionForm(messageId)">
            ✏️ Suggest Correction
        </button>
    </div>
</div>
```

### JavaScript for Feedback
```javascript
async function submitFeedback(messageId, wasHelpful, score) {
    const response = await fetch(`/api/ai/feedback/${messageId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            was_helpful: wasHelpful,
            score: score
        })
    });

    if (response.ok) {
        alert('Thank you for your feedback! 🙏');
        // Update UI to show feedback submitted
    }
}
```

---

## 🔄 Continuous Improvement

### Daily Auto-Learning Cron
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Learn from quality interactions
    $schedule->call(function () {
        $service = app(\App\Services\AgentAi\AiLearningService::class);
        $learned = $service->autoLearnFromQualityInteractions();
        \Log::info("AI learned from {$learned} interactions");
    })->daily();
}
```

### Weekly Knowledge Cleanup
```php
$schedule->call(function () {
    // Remove low-quality, unused knowledge
    AiKnowledgeBase::where('relevance_score', '<', 2.0)
        ->where('usage_count', '<', 3)
        ->where('created_at', '<', now()->subMonths(3))
        ->delete();
})->weekly();
```

---

## 💡 Pro Tips

### 1. **Seed Domain-Specific Knowledge**
Add your organization's specific security policies, tools, and procedures to the knowledge base.

### 2. **Encourage User Feedback**
Gamify feedback with points/badges to encourage users to rate responses.

### 3. **Expert Review**
Have security experts periodically review and verify high-usage knowledge entries.

### 4. **A/B Test Prompts**
Test different system prompts to see which performs better.

### 5. **Monitor Performance**
Track metrics like response time, user satisfaction, and knowledge base hit rate.

---

## 🐛 Troubleshooting

### AI Not Using Knowledge Base
**Check:**
1. Knowledge base has entries: `SELECT COUNT(*) FROM ai_knowledge_base;`
2. Full-text search is working: `SHOW INDEX FROM ai_knowledge_base;`
3. Relevance scores are >= 3.0

### Low Feedback Rate
**Solutions:**
1. Make feedback buttons more prominent
2. Add quick rating (1-5 stars) instead of just thumbs up/down
3. Show "Was this helpful?" after every AI response

### Knowledge Base Growing Too Fast
**Solutions:**
1. Increase minimum feedback score for auto-add (from 4 to 5)
2. Enable admin approval for new knowledge entries
3. Implement deduplication logic

---

## 📚 Next Steps

1. ✅ **Run migration and seeder**
2. ✅ **Test basic AI functionality**
3. ✅ **Add feedback UI to chat interface**
4. ✅ **Monitor first week of learning**
5. ✅ **Review and verify high-usage knowledge**
6. ✅ **Customize system prompts for your domain**
7. ✅ **Set up cron jobs for auto-learning**
8. ✅ **Create admin dashboard for knowledge management**

---

## 🎓 Learn More

- [Full Documentation](./AI_LEARNING_SYSTEM.md)
- [API Reference](./API_REFERENCE.md)
- [Best Practices](./BEST_PRACTICES.md)

---

**Questions?** Check the full documentation or create an issue.

**Happy Learning! 🚀🧠**
