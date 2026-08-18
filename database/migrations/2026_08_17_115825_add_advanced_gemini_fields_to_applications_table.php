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
        Schema::table('applications', function (Blueprint $table) {
            $table->text('job_description')->nullable();
            $table->text('resume_feedback')->nullable();
            $table->text('interview_prep_notes')->nullable();
            $table->timestamp('interview_date')->nullable();
            $table->text('interview_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'job_description',
                'resume_feedback',
                'interview_prep_notes',
                'interview_date',
                'interview_link',
            ]);
        });
    }
};
