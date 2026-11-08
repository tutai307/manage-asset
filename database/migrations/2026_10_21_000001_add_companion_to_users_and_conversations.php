<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // The student's chosen role-play character; null until they choose one.
            $table->string('companion', 20)->nullable()->after('locale');
        });

        Schema::table('conversations', function (Blueprint $table) {
            // Who played the AI side of this conversation.
            $table->string('companion', 20)->nullable()->after('roleplay_scenario_id');
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('companion');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('companion');
        });
    }
};
