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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            
            // General
            $table->string('site_name')->nullable()->default('RD-VIROLOGI');
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            
            // SEO Homepage & Global
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            
            // External Scripts & Verifications
            $table->string('google_analytics_id')->nullable();
            $table->string('google_console_verification')->nullable();
            $table->text('custom_head_scripts')->nullable(); // For <head> scripts like GTM or Pixel
            $table->text('custom_body_scripts')->nullable(); // For scripts right after <body> or before </body>
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
