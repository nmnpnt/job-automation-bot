<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('applications', 'content_type')) {
            Schema::table('applications', function (Blueprint $table) {
                $table->dropIndex(['user_id', 'content_type']);
                $table->dropColumn('content_type');
            });
        }
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('content_type')->default('job')->after('application_source');
            $table->index(['user_id', 'content_type']);
        });
    }
};