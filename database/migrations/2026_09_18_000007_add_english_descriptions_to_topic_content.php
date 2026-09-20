<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->text('description_en')->nullable()->after('description_vi');
        });

        Schema::table('roleplay_scenarios', function (Blueprint $table) {
            $table->text('situation_en')->nullable()->after('situation_vi');
        });
    }

    public function down(): void
    {
        Schema::table('roleplay_scenarios', function (Blueprint $table) {
            $table->dropColumn('situation_en');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('description_en');
        });
    }
};
