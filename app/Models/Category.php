<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Category Model
 * 
 * Represents a Jeopardy game category that contains multiple questions.
 * Categories are displayed as columns on the game board and can be reordered.
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $order
 * @property bool $is_final_jeopardy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'order', 'is_final_jeopardy'];

    /**
     * Get all questions that belong to this category
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
