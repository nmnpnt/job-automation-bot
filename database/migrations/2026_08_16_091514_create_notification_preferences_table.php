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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Events
            $table->boolean('notify_on_submitted')->default(true);
            $table->boolean('notify_on_external')->default(true);
            $table->boolean('notify_on_company_website')->default(true);
            $table->boolean('notify_on_failed')->default(true);
            $table->boolean('notify_on_manual_required')->default(true);
            $table->boolean('notify_on_duplicate')->default(true);
            $table->boolean('notify_on_interview')->default(true);
            $table->boolean('daily_summary')->default(true);

            // Channels
            $table->boolean('channel_in_app')->default(true);
            $table->boolean('channel_email')->default(true);
            $table->boolean('channel_push')->default(true);
            $table->boolean('channel_telegram')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
