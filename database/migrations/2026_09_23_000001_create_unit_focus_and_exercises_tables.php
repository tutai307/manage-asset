<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The vocabulary and grammar a unit actually teaches. Entered or approved by the teacher,
        // so every generated exercise can be constrained to what the class has really been taught.
        Schema::table('curriculum_units', function (Blueprint $table) {
            $table->string('grammar_en', 500)->nullable()->after('focus_en');
            $table->string('grammar_vi', 500)->nullable()->after('grammar_en');
            $table->boolean('focus_approved')->default(false)->after('grammar_vi');
        });

        Schema::create('unit_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_unit_id')->constrained()->cascadeOnDelete();
            $table->string('word', 100);
            $table->string('part_of_speech', 20)->nullable();
            $table->string('meaning_vi', 200);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['curriculum_unit_id', 'word']);
        });

        Schema::create('skill_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_unit_id')->constrained()->cascadeOnDelete();
            $table->string('skill', 20)->index();
            $table->string('title_en', 150);
            $table->string('title_vi', 150);
            $table->string('instructions_vi', 300);
            $table->string('instructions_en', 300);
            $table->text('passage')->nullable();          // reading text, or the script read aloud for listening
            $table->text('prompt_vi')->nullable();        // writing task, in Vietnamese
            $table->text('prompt_en')->nullable();
            $table->unsignedSmallInteger('min_words')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->string('model', 100)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['curriculum_unit_id', 'skill', 'status']);
        });

        Schema::create('exercise_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_exercise_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30);
            $table->string('prompt', 500);
            $table->json('options')->nullable();
            $table->string('answer', 200);
            $table->string('explanation_vi', 300)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->index(['skill_exercise_id', 'sort_order']);
        });

        // Append-only: one row per attempt, so progress over time stays visible.
        Schema::create('exercise_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('score')->default(0);
            $table->unsignedSmallInteger('max_score')->default(0);
            $table->json('answers');
            $table->text('written_answer')->nullable();
            $table->text('feedback_vi')->nullable();
            $table->text('feedback_en')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'skill_exercise_id']);
            $table->index(['skill_exercise_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_attempts');
        Schema::dropIfExists('exercise_questions');
        Schema::dropIfExists('skill_exercises');
        Schema::dropIfExists('unit_vocabulary');

        Schema::table('curriculum_units', function (Blueprint $table) {
            $table->dropColumn(['grammar_en', 'grammar_vi', 'focus_approved']);
        });
    }
};
