<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 5: tournaments table
// database/migrations/2024_01_01_000004_create_tournaments_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('organizer_id');
            $table->enum('format', ['single_elimination', 'double_elimination', 'round_robin', 'swiss'])->default('single_elimination');
            $table->integer('max_teams');
            $table->integer('team_size')->default(5);
            $table->decimal('prize_pool', 10, 2)->nullable();
            $table->string('banner_image')->nullable()->default('tournaments/banners/default.jpg');
            $table->date('registration_start');
            $table->date('registration_end');
            $table->date('tournament_start');
            $table->date('tournament_end')->nullable();
            $table->enum('status', ['draft', 'registration_open', 'registration_closed', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->json('rules')->nullable();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
