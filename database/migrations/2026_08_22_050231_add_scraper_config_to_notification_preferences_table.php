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
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->string('target_roles')->nullable()->default('Software Engineer, Developer');
            $table->string('target_locations')->nullable()->default('Remote, San Francisco, New York');
            $table->string('remote_preference')->nullable()->default('Remote Only');
            $table->integer('max_job_age_days')->default(7);
            $table->boolean('notify_on_high_match')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->dropColumn([
                'target_roles',
                'target_locations',
                'remote_preference',
                'max_job_age_days',
                'notify_on_high_match'
            ]);
        });
    }
};
