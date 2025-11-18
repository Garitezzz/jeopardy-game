<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Order and Image Fields Migration
 * 
 * Adds order field to categories table for drag-and-drop reordering.
 * Adds image_path field to questions table for question images.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds order column to categories and image_path to questions
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('description');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     * Removes order and image_path columns
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
