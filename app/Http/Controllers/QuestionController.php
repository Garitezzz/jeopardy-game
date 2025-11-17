<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('category')->orderBy('category_id')->orderBy('points')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|string',
            'answer' => 'required|string',
            'points' => 'required|integer|min:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            'answer_video' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'answer_audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);

        $data = $request->except(['image', 'answer_image', 'video', 'audio', 'answer_video', 'answer_audio']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('questions', 'public');
            $data['image_path'] = $path;
        }
        
        if ($request->hasFile('answer_image')) {
            $path = $request->file('answer_image')->store('questions/answers', 'public');
            $data['answer_image_path'] = $path;
        }
        
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('questions/videos', 'public');
            $data['video_path'] = $path;
        }
        
        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('questions/audio', 'public');
            $data['audio_path'] = $path;
        }
        
        if ($request->hasFile('answer_video')) {
            $path = $request->file('answer_video')->store('questions/answers/videos', 'public');
            $data['answer_video_path'] = $path;
        }
        
        if ($request->hasFile('answer_audio')) {
            $path = $request->file('answer_audio')->store('questions/answers/audio', 'public');
            $data['answer_audio_path'] = $path;
        }

        // Handle swap if a question with the same point value exists
        if ($request->has('swap_question_id')) {
            $existingQuestion = Question::find($request->swap_question_id);
            if ($existingQuestion && $existingQuestion->category_id == $request->category_id) {
                // Find an available point value for the existing question
                $standardPoints = [200, 400, 600, 800, 1000];
                $usedPoints = Question::where('category_id', $request->category_id)
                    ->pluck('points')
                    ->toArray();
                
                // Find first available point value
                $newPoints = null;
                foreach ($standardPoints as $points) {
                    if (!in_array($points, $usedPoints) || $points == $request->points) {
                        $newPoints = $points;
                        break;
                    }
                }
                
                // If no standard point available, use a custom value
                if ($newPoints === null) {
                    $newPoints = max($usedPoints) + 200;
                }
                
                // Update the existing question's point value
                $existingQuestion->update(['points' => $newPoints]);
            }
        }

        Question::create($data);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully!');
    }

    public function edit(Question $question)
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|string',
            'answer' => 'required|string',
            'points' => 'required|integer|min:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            'answer_video' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'answer_audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);

        $data = $request->except(['image', 'answer_image', 'video', 'audio', 'answer_video', 'answer_audio']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
            }
            $path = $request->file('image')->store('questions', 'public');
            $data['image_path'] = $path;
        }
        
        if ($request->hasFile('answer_image')) {
            // Delete old answer image if exists
            if ($question->answer_image_path) {
                Storage::disk('public')->delete($question->answer_image_path);
            }
            $path = $request->file('answer_image')->store('questions/answers', 'public');
            $data['answer_image_path'] = $path;
        }
        
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($question->video_path) {
                Storage::disk('public')->delete($question->video_path);
            }
            $path = $request->file('video')->store('questions/videos', 'public');
            $data['video_path'] = $path;
        }
        
        if ($request->hasFile('audio')) {
            // Delete old audio if exists
            if ($question->audio_path) {
                Storage::disk('public')->delete($question->audio_path);
            }
            $path = $request->file('audio')->store('questions/audio', 'public');
            $data['audio_path'] = $path;
        }
        
        if ($request->hasFile('answer_video')) {
            // Delete old answer video if exists
            if ($question->answer_video_path) {
                Storage::disk('public')->delete($question->answer_video_path);
            }
            $path = $request->file('answer_video')->store('questions/answers/videos', 'public');
            $data['answer_video_path'] = $path;
        }
        
        if ($request->hasFile('answer_audio')) {
            // Delete old answer audio if exists
            if ($question->answer_audio_path) {
                Storage::disk('public')->delete($question->answer_audio_path);
            }
            $path = $request->file('answer_audio')->store('questions/answers/audio', 'public');
            $data['answer_audio_path'] = $path;
        }

        // Handle swap if a question with the same point value exists
        if ($request->has('swap_question_id')) {
            $existingQuestion = Question::find($request->swap_question_id);
            if ($existingQuestion && $existingQuestion->category_id == $request->category_id && $existingQuestion->id != $question->id) {
                // Find an available point value for the existing question
                $standardPoints = [200, 400, 600, 800, 1000];
                $usedPoints = Question::where('category_id', $request->category_id)
                    ->where('id', '!=', $question->id) // Exclude current question
                    ->pluck('points')
                    ->toArray();
                
                // Find first available point value
                $newPoints = null;
                foreach ($standardPoints as $points) {
                    if (!in_array($points, $usedPoints) || $points == $request->points) {
                        $newPoints = $points;
                        break;
                    }
                }
                
                // If no standard point available, use a custom value
                if ($newPoints === null) {
                    $newPoints = max($usedPoints) + 200;
                }
                
                // Update the existing question's point value
                $existingQuestion->update(['points' => $newPoints]);
            }
        }

        $question->update($data);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully!');
    }

    public function destroy(Question $question)
    {
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }
        if ($question->answer_image_path) {
            Storage::disk('public')->delete($question->answer_image_path);
        }
        
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully!');
    }
    
    public function updatePoints(Request $request, Question $question)
    {
        $request->validate([
            'points' => 'required|integer|min:100'
        ]);
        
        $question->update(['points' => $request->points]);
        
        return response()->json(['success' => true, 'points' => $question->points]);
    }
}

