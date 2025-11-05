<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 11: match_reviews table
// database/migrations/2024_01_01_000010_create_match_reviews_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('user_id');
            $table->text('review_text');
            $table->integer('rating');
            $table->enum('category', ['gameplay', 'organization', 'fairness', 'overall'])->default('overall');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_reviews');
    }
};