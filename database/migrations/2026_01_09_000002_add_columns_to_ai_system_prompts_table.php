<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_system_prompts', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_system_prompts', 'name')) {
                $table->string('name', 100)->nullable()->after('id');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'version')) {
                $table->string('version', 20)->default('1.0')->after('name');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'base_prompt')) {
                $table->text('base_prompt')->nullable()->after('version');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'personality_traits')) {
                $table->text('personality_traits')->nullable()->after('content');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'capabilities')) {
                $table->text('capabilities')->nullable()->after('personality_traits');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'response_templates')) {
                $table->text('response_templates')->nullable()->after('capabilities');
            }
            if (!Schema::hasColumn('ai_system_prompts', 'custom_rules')) {
                $table->text('custom_rules')->nullable()->after('response_templates');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_system_prompts', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'version', 'base_prompt', 'personality_traits', 
                'capabilities', 'response_templates', 'custom_rules'
            ]);
        });
    }
};
