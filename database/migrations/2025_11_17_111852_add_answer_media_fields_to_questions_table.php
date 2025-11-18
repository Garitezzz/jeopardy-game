<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Answer Media Fields Migration
 * 
 * Adds video and audio support for answers.
 * Allows displaying video or playing audio when revealing the answer.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds answer_video_path and answer_audio_path columns to questions table
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('answer_video_path')->nullable()->after('answer_image_path');
            $table->string('answer_audio_path')->nullable()->after('answer_video_path');
        });
    }

    /**
     * Reverse the migrations.
     * Removes answer media columns
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['answer_video_path', 'answer_audio_path']);
        });
    }
};
