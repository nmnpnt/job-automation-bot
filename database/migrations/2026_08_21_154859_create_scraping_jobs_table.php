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
        Schema::create('scraping_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('schedule_id')->nullable()->constrained('scraping_schedules')->nullOnDelete();
            $table->json('platforms');
            $table->enum('status', ['running', 'completed', 'failed']);
            $table->enum('trigger_type', ['manual', 'scheduled']);
            $table->integer('total_urls_found')->default(0);
            $table->integer('processed_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('error_log')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraping_jobs');
    }
};
