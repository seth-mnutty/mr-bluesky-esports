<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 8: player_performance table
// database/migrations/2024_01_01_000007_create_player_performance_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_performance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('team_id');
            $table->integer('kills')->default(0);
            $table->integer('deaths')->default(0);
            $table->integer('assists')->default(0);
            $table->decimal('kda_ratio', 5, 2)->default(0.00);
            $table->integer('damage_dealt')->default(0);
            $table->integer('healing_done')->default(0);
            $table->integer('objectives_captured')->default(0);
            $table->decimal('accuracy', 5, 2)->nullable();
            $table->json('additional_stats')->nullable();
            $table->timestamps();
            
            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unique(['match_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_performance');
    }
};