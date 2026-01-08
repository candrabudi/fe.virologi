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
            $table->string('email')->after('full_name')->nullable();
            $table->string('phone_number')->after('email')->nullable();
            $table->string('requester_status')->after('department')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leak_data_requests', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone_number', 'requester_status']);
        });
    }
};
