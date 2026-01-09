<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. AI System Prompts - skip if exists or handle carefully
        if (!Schema::hasTable('ai_system_prompts')) {
            Schema::create('ai_system_prompts', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('version', 20)->default('1.0');
                $table->text('base_prompt');
                $table->text('personality_traits')->nullable();
                $table->text('capabilities')->nullable();
                $table->text('response_templates')->nullable();
                $table->text('custom_rules')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('priority')->default(0);
                $table->timestamps();
            });
        }

        // 2. AI Knowledge Base - Knowledge storage
        if (!Schema::hasTable('ai_knowledge_base')) {
            Schema::create('ai_knowledge_base', function (Blueprint $table) {
                $table->id();
                $table->string('category', 50);
                $table->string('topic', 200);
                $table->text('content');
                $table->text('context')->nullable();
                $table->text('examples')->nullable();
                $table->text('references')->nullable();
                $table->text('tags')->nullable();
                $table->text('embedding')->nullable();
                $table->integer('usage_count')->default(0);
                $table->decimal('relevance_score', 5, 2)->default(0);
                $table->string('source', 50)->default('user_interaction');
                $table->foreignId('created_by')->nullable()->constrained('users');
                $table->timestamp('last_used_at')->nullable();
                $table->timestamps();
                
                $table->fullText(['topic', 'content']);
            });
        }

        // 3. AI Learning Sessions
        if (!Schema::hasTable('ai_learning_sessions')) {
            Schema::create('ai_learning_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chat_session_id')->constrained('ai_chat_sessions')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users');
                $table->text('user_query');
                $table->text('ai_response');
                $table->text('extracted_insights')->nullable();
                $table->boolean('was_helpful')->nullable();
                $table->integer('feedback_score')->nullable();
                $table->text('correction')->nullable();
                $table->boolean('added_to_knowledge_base')->default(false);
                $table->foreignId('knowledge_base_id')->nullable()->constrained('ai_knowledge_base');
                $table->timestamps();
            });
        }

        // 4. AI Behavior Rules
        if (!Schema::hasTable('ai_behavior_rules')) {
            Schema::create('ai_behavior_rules', function (Blueprint $table) {
                $table->id();
                $table->string('rule_name', 100);
                $table->string('trigger_condition', 200);
                $table->text('rule_description');
                $table->text('action');
                $table->text('examples')->nullable();
                $table->integer('priority')->default(0);
                $table->boolean('is_active')->default(true);
                $table->string('scope', 50)->default('global');
                $table->timestamps();
            });
        }

        // 5. AI Code Snippets
        if (!Schema::hasTable('ai_code_snippets')) {
            Schema::create('ai_code_snippets', function (Blueprint $table) {
                $table->id();
                $table->string('language', 50);
                $table->string('category', 100);
                $table->string('title', 200);
                $table->text('description');
                $table->text('secure_code');
                $table->text('insecure_code')->nullable();
                $table->text('explanation');
                $table->text('security_benefits')->nullable();
                $table->text('test_cases')->nullable();
                $table->text('dependencies')->nullable();
                $table->integer('usage_count')->default(0);
                $table->decimal('rating', 3, 2)->default(0);
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
                
                $table->fullText(['title', 'description']);
            });
        }

        // 6. AI Training Data
        if (!Schema::hasTable('ai_training_data')) {
            Schema::create('ai_training_data', function (Blueprint $table) {
                $table->id();
                $table->string('category', 100);
                $table->text('question');
                $table->text('ideal_answer');
                $table->text('context')->nullable();
                $table->text('metadata')->nullable();
                $table->boolean('is_approved')->default(false);
                $table->foreignId('approved_by')->nullable()->constrained('users');
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();
            });
        }

        // 7. AI Performance Metrics
        if (!Schema::hasTable('ai_performance_metrics')) {
            Schema::create('ai_performance_metrics', function (Blueprint $table) {
                $table->id();
                $table->date('metric_date');
                $table->integer('total_queries')->default(0);
                $table->integer('successful_responses')->default(0);
                $table->integer('failed_responses')->default(0);
                $table->decimal('average_response_time', 8, 2)->default(0);
                $table->decimal('user_satisfaction_score', 3, 2)->default(0);
                $table->integer('knowledge_base_hits')->default(0);
                $table->integer('new_learnings')->default(0);
                $table->text('top_topics')->nullable();
                $table->text('improvement_areas')->nullable();
                $table->timestamps();
                
                $table->unique('metric_date');
            });
        }

        // 8. AI Feedback & Corrections
        if (!Schema::hasTable('ai_feedback')) {
            Schema::create('ai_feedback', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chat_message_id')->constrained('ai_chat_messages')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users');
                $table->enum('feedback_type', ['helpful', 'not_helpful', 'incorrect', 'incomplete', 'excellent']);
                $table->integer('rating')->nullable();
                $table->text('comment')->nullable();
                $table->text('suggested_improvement')->nullable();
                $table->boolean('reviewed_by_admin')->default(false);
                $table->boolean('applied_to_training')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_feedback');
        Schema::dropIfExists('ai_performance_metrics');
        Schema::dropIfExists('ai_training_data');
        Schema::dropIfExists('ai_code_snippets');
        Schema::dropIfExists('ai_behavior_rules');
        Schema::dropIfExists('ai_learning_sessions');
        Schema::dropIfExists('ai_knowledge_base');
        Schema::dropIfExists('ai_system_prompts');
    }
};
