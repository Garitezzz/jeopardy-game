<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
