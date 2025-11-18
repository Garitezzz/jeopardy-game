<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Game Responses Table Migration
 * 
 * Creates the game_responses table to track answers submitted during games.
 * Stores which questions were answered in each game and whether they were correct.
 * Includes cascade delete when parent game or question is deleted.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates game_responses table with game and question relationships and correctness flag
     */
    public function up(): void
    {
        Schema::create('game_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Drops the game_responses table
     */
    public function down(): void
    {
        Schema::dropIfExists('game_responses');
    }
};
