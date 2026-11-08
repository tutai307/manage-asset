<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skill_exercises', function (Blueprint $table) {
            // A teacher's own test can span several units, so the unit becomes optional.
            $table->foreignId('curriculum_unit_id')->nullable()->change();

            // Null for shipped and unit practice (open to the whole grade); set for an exercise a
            // teacher made, which only the classes it is assigned to can see.
            $table->foreignId('owner_id')->nullable()->after('curriculum_unit_id')->constrained('users')->nullOnDelete();
            $table->string('source', 20)->default('generated')->after('owner_id');
            $table->unsignedTinyInteger('grade')->nullable()->after('source');

            // The uploaded test the exercise was read from, kept for the teacher's side-by-side check.
            $table->json('source_files')->nullable()->after('model');
        });

        Schema::table('exercise_questions', function (Blueprint $table) {
            // Other wordings accepted for a rewrite question.
            $table->json('accepted_answers')->nullable()->after('answer');
            // Set when an exercise was read from an upload and this question should be checked.
            $table->boolean('needs_check')->default(false)->after('explanation_vi');
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_exercise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_by')->constrained('users');
            $table->timestamp('due_at')->nullable();
            $table->timestamps();

            $table->unique(['skill_exercise_id', 'classroom_id']);
            $table->index(['classroom_id', 'due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');

        Schema::table('exercise_questions', function (Blueprint $table) {
            $table->dropColumn(['accepted_answers', 'needs_check']);
        });

        Schema::table('skill_exercises', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_id');
            $table->dropColumn(['source', 'grade', 'source_files']);
        });
    }
};
