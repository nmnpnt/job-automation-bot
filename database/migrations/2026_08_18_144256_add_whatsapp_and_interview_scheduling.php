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
            $table->boolean('channel_whatsapp')->default(false)->after('channel_slack');
            $table->string('whatsapp_phone_number')->nullable()->after('channel_whatsapp');
            $table->string('whatsapp_api_key')->nullable()->after('whatsapp_phone_number');
            $table->string('whatsapp_provider')->default('callmebot')->after('whatsapp_api_key');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dateTime('interview_scheduled_at')->nullable()->after('submitted_at');
            $table->string('interview_type')->nullable()->after('interview_scheduled_at');
            $table->string('interview_meeting_link')->nullable()->after('interview_type');
            $table->text('interview_notes')->nullable()->after('interview_meeting_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->dropColumn([
                'channel_whatsapp',
                'whatsapp_phone_number',
                'whatsapp_api_key',
                'whatsapp_provider',
            ]);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'interview_scheduled_at',
                'interview_type',
                'interview_meeting_link',
                'interview_notes',
            ]);
        });
    }
};
