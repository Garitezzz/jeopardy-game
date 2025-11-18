<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Answer Image Field Migration
 * 
 * Adds answer_image_path field to questions table.
 * Allows displaying an image when revealing the answer.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds answer_image_path column to questions table
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('answer_image_path')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     * Removes answer_image_path column
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('answer_image_path');
        });
    }
};
