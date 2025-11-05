<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration 3: teams table
// database/migrations/2024_01_01_000002_create_teams_table.php

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tag', 10)->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable()->default('teams/logos/default.png');
            $table->unsignedBigInteger('captain_id');
            $table->integer('max_members')->default(5);
            $table->decimal('win_rate', 5, 2)->default(0.00);
            $table->integer('total_matches')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('captain_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
