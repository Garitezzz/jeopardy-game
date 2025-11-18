<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Game Model
 * 
 * Represents a Jeopardy game session for tracking a single player's progress and score.
 * Each game can have multiple responses to questions.
 * 
 * @property int $id
 * @property string $player_name
 * @property int $score
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameResponse> $responses
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = ['player_name', 'score', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all responses/answers submitted in this game session
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(GameResponse::class);
    }
}
