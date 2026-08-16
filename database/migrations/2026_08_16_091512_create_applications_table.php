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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->nullable(); // Reference to job
            $table->string('application_source')->default('UNKNOWN');
            $table->text('application_url')->nullable();
            $table->text('original_job_url')->nullable();
            $table->string('external_domain')->nullable();
            $table->string('application_method')->nullable();
            $table->boolean('can_auto_apply')->default(false);
            $table->string('status')->default('DISCOVERED');
            $table->timestamp('submitted_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->string('confirmation_id')->nullable();
            $table->timestamp('last_attempt_at')->nullable();
            $table->integer('attempt_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
