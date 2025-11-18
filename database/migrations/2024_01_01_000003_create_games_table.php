<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Games Table Migration
 * 
 * Creates the games table to track individual game sessions.
 * Each game represents a single player's session with their score and active status.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates games table with player name, score, and active status
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('player_name');
            $table->integer('score')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Drops the games table
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
