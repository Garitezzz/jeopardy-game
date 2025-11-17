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
    public function index()
    {
        $categories = Category::with('questions')->orderBy('order')->get();
        return view('game.board', compact('categories'));
    }

    public function showSingleQuestion(Question $question)
    {
        $question->load('category');
        return view('game.question', compact('question'));
    }

    public function create()
    {
        return view('game.create');
    }

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

    public function play(Game $game)
    {
        $categories = Category::with('questions')->get();
        $answeredQuestionIds = $game->responses()->pluck('question_id')->toArray();
        
        return view('game.play', compact('game', 'categories', 'answeredQuestionIds'));
    }

    public function showQuestion(Game $game, Question $question)
    {
        return view('game.question', compact('game', 'question'));
    }

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

    public function end(Game $game)
    {
        $game->update(['is_active' => false]);
        return view('game.end', compact('game'));
    }
    
    public function showRules()
    {
        $rules = Settings::get('rules_content');
        return view('game.rules', compact('rules'));
    }
    
    public function showMainTitle()
    {
        $settings = (object) [
            'title' => Settings::get('main_title', 'JEOPARDY!'),
            'subtitle' => Settings::get('main_subtitle'),
            'logo_path' => Settings::get('main_logo'),
        ];
        return view('game.main-title', compact('settings'));
    }
}
