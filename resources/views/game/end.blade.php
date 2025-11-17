@extends('layouts.app')

@section('title', 'Game Over')

@section('content')
<style>
    .game-over {
        text-align: center;
        padding: 50px;
        max-width: 600px;
        margin: 100px auto;
    }
    
    .final-score {
        font-size: 4em;
        color: #ffd700;
        margin: 30px 0;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
    }
    
    .game-stats {
        background: rgba(0, 0, 0, 0.3);
        padding: 30px;
        border-radius: 10px;
        margin: 30px 0;
    }
    
    .stat-item {
        margin: 15px 0;
        font-size: 1.2em;
    }
</style>

<div class="card game-over">
    <h2 style="color: #ffd700; font-size: 2.5em;">🎉 Game Over!</h2>
    
    <div class="game-stats">
        <div class="stat-item">
            <strong>Player:</strong> {{ $game->player_name }}
        </div>
        <div class="stat-item">
            <strong>Questions Answered:</strong> {{ $game->responses->count() }}
        </div>
        <div class="stat-item">
            <strong>Correct Answers:</strong> {{ $game->responses->where('is_correct', true)->count() }}
        </div>
    </div>
    
    <div class="final-score">
        {{ $game->score }} Points
    </div>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('game.create') }}" class="btn">Play Again</a>
    </div>
</div>
@endsection
