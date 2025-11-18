{{--
    Game Play View
    
    Active game session view showing the board with answered questions marked.
--}}
@extends('layouts.app')

@section('title', 'Play Jeopardy')

@section('content')
<style>
    .board {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .category-column {
        background: rgba(0, 0, 0, 0.4);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .category-header {
        background: #ffd700;
        color: #000;
        padding: 15px;
        text-align: center;
        font-weight: bold;
        font-size: 1.1em;
    }
    
    .question-card {
        background: #0f52ba;
        margin: 10px;
        padding: 30px;
        text-align: center;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        color: #ffd700;
        font-size: 1.5em;
        font-weight: bold;
    }
    
    .question-card:hover {
        background: #1a66d4;
        transform: scale(1.05);
    }
    
    .question-card.answered {
        background: #333;
        color: #666;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .controls {
        text-align: center;
        margin: 30px 0;
    }
</style>

@if(session('result'))
    <div class="alert {{ session('result')['correct'] ? 'alert-success' : 'alert-error' }}">
        @if(session('result')['correct'])
            <strong>Correct!</strong> You earned {{ session('result')['points'] }} points!
        @else
            <strong>Incorrect!</strong> The correct answer was: {{ session('result')['answer'] }}
        @endif
    </div>
@endif

<div class="board">
    @foreach($categories as $category)
        <div class="category-column">
            <div class="category-header">{{ $category->name }}</div>
            @foreach($category->questions as $question)
                @if(in_array($question->id, $answeredQuestionIds))
                    <div class="question-card answered">---</div>
                @else
                    <a href="{{ route('game.question', [$game, $question]) }}" class="question-card">
                        ${{ $question->points }}
                    </a>
                @endif
            @endforeach
        </div>
    @endforeach
</div>

<div class="controls">
    <a href="{{ route('game.end', $game) }}" class="btn btn-secondary">End Game</a>
</div>
@endsection
