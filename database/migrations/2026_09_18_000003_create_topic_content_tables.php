<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('title_en', 150);
            $table->string('title_vi', 150);
            $table->text('description_vi')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('sentence_patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('english', 255);
            $table->string('vietnamese', 255);
            $table->string('note_vi', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['topic_id', 'sort_order']);
        });

        Schema::create('roleplay_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('title_en', 150);
            $table->string('title_vi', 150);
            $table->text('situation_vi');
            $table->string('ai_role', 100);
            $table->string('student_role', 100);
            $table->string('opening_line', 255);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['topic_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roleplay_scenarios');
        Schema::dropIfExists('sentence_patterns');
        Schema::dropIfExists('topics');
    }
};
