<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Final Jeopardy Flag Migration
 * 
 * Adds is_final_jeopardy flag to categories table.
 * Allows marking categories as Final Jeopardy round categories.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds is_final_jeopardy boolean column to categories table
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_final_jeopardy')->default(false)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     * Removes is_final_jeopardy column
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_final_jeopardy');
        });
    }
};
