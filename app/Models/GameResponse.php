<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
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

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
