<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Question Model
 * 
 * Represents a Jeopardy question with its answer, point value, and optional media attachments.
 * Each question belongs to a category and can have images, videos, or audio files.
 * 
 * @property int $id
 * @property int $category_id
 * @property string $question
 * @property string $answer
 * @property int $points
 * @property string|null $difficulty
 * @property string|null $image_path
 * @property string|null $answer_image_path
 * @property string|null $video_path
 * @property string|null $audio_path
 * @property string|null $answer_video_path
 * @property string|null $answer_audio_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'points',
        'order',
        'image_path',
        'answer_image_path',
        'answer_video_path',
        'answer_audio_path',
        'video_path',
        'audio_path',
    ];

    /**
     * Get the category that this question belongs to
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
