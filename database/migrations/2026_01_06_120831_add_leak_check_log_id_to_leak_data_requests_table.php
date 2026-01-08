<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leak_data_requests', function (Blueprint $table) {
            $table->foreignId('leak_check_log_id')->after('user_id')->nullable()->constrained('leak_check_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leak_data_requests', function (Blueprint $table) {
            $table->dropForeign(['leak_check_log_id']);
            $table->dropColumn('leak_check_log_id');
        });
    }
};
