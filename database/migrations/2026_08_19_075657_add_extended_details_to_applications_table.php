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
            $table->boolean('is_read')->default(false)->after('status');
            $table->string('interview_round')->nullable()->after('interview_type');
            $table->text('description')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('skills_required')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('experience_required')->nullable();
            $table->string('salary_info')->nullable();
            $table->string('employment_type')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('application_deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'is_read',
                'interview_round',
                'description',
                'responsibilities',
                'skills_required',
                'qualifications',
                'experience_required',
                'salary_info',
                'employment_type',
                'posted_at',
                'application_deadline'
            ]);
        });
    }
};
