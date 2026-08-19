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
            $table->index('user_id');
            $table->index('status');
            $table->index('application_source');
            $table->index(['user_id', 'status']);
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->index('queue');
            $table->index('failed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['application_source']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->dropIndex(['queue']);
            $table->dropIndex(['failed_at']);
        });
    }
};
