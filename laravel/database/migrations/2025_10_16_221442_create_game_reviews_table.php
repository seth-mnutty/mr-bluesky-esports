<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 10: game_reviews table
// database/migrations/2024_01_01_000009_create_game_reviews_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('review_text');
            $table->integer('rating');
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_reviews');
    }
};
