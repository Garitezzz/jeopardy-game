<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use App\Models\Question;
use App\Models\GameResponse;
use App\Models\Settings;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display the main game board with all categories and questions
     */
    public function board()
    {
        $categories = Category::with('questions')->orderBy('order')->get();
        return view('game.board', compact('categories'));
    }

    /**
     * Alternative method to display the game board (same as board method)
     */
    public function index()
    {
        $categories = Category::with('questions')->orderBy('order')->get();
        return view('game.board', compact('categories'));
    }

    /**
     * Show a specific question by ID in fullscreen modal view
     */
    public function showQuestion($id)
    {
        $question = Question::with('category')->findOrFail($id);
        return view('game.question', compact('question'));
    }

    /**
     * Show a specific question using route model binding
     */
    public function showSingleQuestion(Question $question)
    {
        $question->load('category');
        return view('game.question', compact('question'));
    }

    /**
     * Display the game rules page
     */
    public function rules()
    {
        $rules = Settings::get('rules_content', 'Default Jeopardy rules...');
        return view('game.rules', compact('rules'));
    }

    /**
     * Display the main title screen with logo and game title
     */
    public function mainTitle()
    {
        $settings = (object) [
            'title' => Settings::get('main_title', 'JEOPARDY!'),
            'subtitle' => Settings::get('main_subtitle'),
            'logo_path' => Settings::get('main_logo'),
        ];
        return view('game.main-title', compact('settings'));
    }

    /**
     * Show the form to create a new game session
     */
    public function create()
    {
        return view('game.create');
    }

    /**
     * Store a new game session with player name and initial score
     */
    public function store(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
        ]);

        $game = Game::create([
            'player_name' => $request->player_name,
            'score' => 0,
            'is_active' => true,
        ]);

        return redirect()->route('game.play', $game);
    }

    /**
     * Display the active game board for a specific game session
     * Shows which questions have been answered
     */
    public function play(Game $game)
    {
        $categories = Category::with('questions')->get();
        $answeredQuestionIds = $game->responses()->pluck('question_id')->toArray();
        
        return view('game.play', compact('game', 'categories', 'answeredQuestionIds'));
    }

    /**
     * Handle answer submission (placeholder for future implementation)
     */
    public function answer(Request $request, Game $game)
    {
        // Handle answer submission
        return redirect()->route('game.play', $game);
    }

    /**
     * Process and validate a submitted answer for a question
     * Updates game score if answer is correct
     */
    public function submitAnswer(Request $request, Game $game, Question $question)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($question->answer));

        GameResponse::create([
            'game_id' => $game->id,
            'question_id' => $question->id,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            $game->increment('score', $question->points);
        }

        return redirect()->route('game.play', $game)->with('result', [
            'correct' => $isCorrect,
            'answer' => $question->answer,
            'points' => $question->points,
        ]);
    }

    /**
     * End the game session and display final score
     */
    public function end(Game $game)
    {
        $game->update(['is_active' => false]);
        return view('game.end', compact('game'));
    }
}
