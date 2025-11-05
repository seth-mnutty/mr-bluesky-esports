<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 7: matches table
// database/migrations/2024_01_01_000006_create_matches_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('team1_id');
            $table->unsignedBigInteger('team2_id');
            $table->integer('round')->default(1);
            $table->integer('match_number');
            $table->dateTime('scheduled_at');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('team1_score')->nullable();
            $table->integer('team2_score')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->string('stream_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('winner_id')->references('id')->on('teams')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};

