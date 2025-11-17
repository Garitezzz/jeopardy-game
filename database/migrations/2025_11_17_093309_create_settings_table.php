<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'main_title',
                'value' => 'JEOPARDY!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'main_subtitle',
                'value' => 'The Ultimate Quiz Show Experience',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'main_logo',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'rules_content',
                'value' => '<h2>Game Rules</h2>
<ul>
    <li><strong>Selecting Questions:</strong> Click on any dollar amount tile to reveal a question.</li>
    <li><strong>Reading Questions:</strong> Read the question carefully. All questions are in the form of answers.</li>
    <li><strong>Answering:</strong> Your response must be phrased in the form of a question (e.g., "What is...?" or "Who is...?").</li>
    <li><strong>Scoring:</strong> Correct answers add the dollar amount to your score. Incorrect answers subtract the amount.</li>
    <li><strong>Used Questions:</strong> Once a question is answered, it becomes unavailable for the rest of the game.</li>
    <li><strong>Player Turns:</strong> Click on a player card to set them as the active player.</li>
    <li><strong>Score Adjustments:</strong> Use the +$100 and -$100 buttons, or type directly in the score field.</li>
    <li><strong>Final Jeopardy:</strong> Use the "Overtime / Final Round" button for the final question.</li>
</ul>

<h2>Game Controls</h2>
<ul>
    <li><strong>Reset Board:</strong> Makes all questions available again.</li>
    <li><strong>Reset Scores:</strong> Sets all player scores back to $0.</li>
    <li><strong>Player Names:</strong> Click on any player name to edit it.</li>
    <li><strong>Game Title:</strong> Click on the main title to edit it.</li>
</ul>

<h2>Tips for Players</h2>
<ul>
    <li>Strategy matters! Higher value questions are typically harder.</li>
    <li>Keep track of categories you are strong in.</li>
    <li>In Final Jeopardy, you can wager any amount up to your total score.</li>
</ul>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
