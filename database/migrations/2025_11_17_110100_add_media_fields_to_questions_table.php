<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Media Fields to Questions Table Migration
 * 
 * Adds video and audio support for questions.
 * Allows attaching video and audio files to questions for multimedia content.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds video_path and audio_path columns to questions table
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('video_path')->nullable()->after('answer_image_path');
            $table->string('audio_path')->nullable()->after('video_path');
        });
    }

    /**
     * Reverse the migrations.
     * Removes video_path and audio_path columns
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['video_path', 'audio_path']);
        });
    }
};
