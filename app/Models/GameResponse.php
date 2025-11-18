<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * GameResponse Model
 * 
 * Represents a player's answer to a specific question during a game session.
 * Tracks whether the answer was correct or incorrect.
 * 
 * @property int $id
 * @property int $game_id
 * @property int $question_id
 * @property bool $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\Question $question
 */
class GameResponse extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'question_id', 'is_correct'];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the game session that this response belongs to
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the question that was answered in this response
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
