<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_behavior_rules', function (Blueprint $table) {
            $table->string('rule_name', 100)->nullable()->after('id');
            $table->string('trigger_condition', 200)->nullable()->after('rule_name');
            $table->text('rule_description')->nullable()->after('trigger_condition');
            $table->text('action')->nullable()->after('rule_description');
            $table->text('examples')->nullable()->after('action');
            $table->string('scope', 50)->default('global')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('ai_behavior_rules', function (Blueprint $table) {
            $table->dropColumn([
                'rule_name', 'trigger_condition', 'rule_description', 
                'action', 'examples', 'scope'
            ]);
        });
    }
};
