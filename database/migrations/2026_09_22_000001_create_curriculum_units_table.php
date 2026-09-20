<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The syllabus skeleton of Tiếng Anh 6-9 (Global Success): grade, unit number, topic and term.
        // Only the structure is stored — no text from the books themselves.
        Schema::create('curriculum_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('grade');
            $table->unsignedTinyInteger('number');
            $table->unsignedTinyInteger('term');
            $table->string('emoji', 16)->nullable();
            $table->string('title_en', 150);
            $table->string('title_vi', 150);
            $table->text('focus_vi')->nullable();
            $table->text('focus_en')->nullable();
            $table->timestamps();

            $table->unique(['grade', 'number']);
            $table->index(['grade', 'term']);
        });

        Schema::table('topics', function (Blueprint $table) {
            // Null for the general communication topics that belong to no unit.
            $table->foreignId('curriculum_unit_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropConstrainedForeignId('curriculum_unit_id');
        });

        Schema::dropIfExists('curriculum_units');
    }
};
