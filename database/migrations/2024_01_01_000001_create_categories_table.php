<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Categories Table Migration
 * 
 * Creates the categories table to store Jeopardy game categories.
 * Each category will contain multiple questions and can be reordered.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates categories table with name, description, and timestamps
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Drops the categories table
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
