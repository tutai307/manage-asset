<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Append-only: a new review is added each time the student asks for feedback; the latest is shown.
        Schema::create('roleplay_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->string('model', 100);
            $table->unsignedTinyInteger('good_count')->default(0);
            $table->unsignedTinyInteger('reviewed_count')->default(0);
            $table->text('summary_vi');
            $table->text('summary_en');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['conversation_id', 'id']);
        });

        Schema::create('roleplay_review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roleplay_review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('conversation_message_id')->nullable()->constrained()->nullOnDelete();
            $table->string('original', 500);
            $table->boolean('is_good')->default(true);
            $table->string('better_en', 500)->nullable();
            $table->string('note_vi', 500)->nullable();
            $table->string('note_en', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->index(['roleplay_review_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roleplay_review_items');
        Schema::dropIfExists('roleplay_reviews');
    }
};
