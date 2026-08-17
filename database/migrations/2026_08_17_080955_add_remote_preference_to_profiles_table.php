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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('remote_preference')->default('include')->after('target_locations');
            // Using dropColumn can be problematic with some SQLite versions, 
            // but Laravel 11 handles it correctly in most cases.
            $table->dropColumn('remote_only');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('remote_preference');
            $table->boolean('remote_only')->default(false);
        });
    }
};
