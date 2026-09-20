<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Append-only learning history: one row each time a student reveals a Vietnamese meaning.
        Schema::create('pattern_reveals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sentence_pattern_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'sentence_pattern_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pattern_reveals');
    }
};
