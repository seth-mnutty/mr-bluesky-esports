<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 6: tournament_registrations table
// database/migrations/2024_01_01_000005_create_tournament_registrations_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('team_id');
            $table->enum('status', ['pending', 'approved', 'rejected', 'withdrawn'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('registered_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unique(['tournament_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
