<?php

// Migration 2: games table
// database/migrations/2024_01_01_000001_create_games_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('genre');
            $table->string('publisher')->nullable();
            $table->date('release_date')->nullable();
            $table->string('cover_image')->nullable()->default('games/covers/default.jpg');
            $table->enum('platform', ['PC', 'PlayStation', 'Xbox', 'Mobile', 'Cross-platform'])->default('PC');
            $table->integer('min_players')->default(1);
            $table->integer('max_players')->default(10);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};