<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Questions Table Migration
 * 
 * Creates the questions table to store Jeopardy questions with answers.
 * Each question belongs to a category and has a point value.
 * Includes cascade delete when parent category is deleted.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates questions table with category relationship, question text, answer, points, and difficulty
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->text('answer');
            $table->integer('points')->default(100);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Drops the questions table
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
