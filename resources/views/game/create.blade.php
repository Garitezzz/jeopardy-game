@extends('layouts.app')

@section('title', 'Start New Game')

@section('content')
<div class="card" style="max-width: 500px; margin: 100px auto;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #ffd700;">Start New Game</h2>
    
    <form action="{{ route('game.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="player_name">Enter Your Name:</label>
            <input type="text" id="player_name" name="player_name" required autofocus>
        </div>
        
        <div style="text-align: center;">
            <button type="submit" class="btn">Start Playing!</button>
        </div>
    </form>
</div>
@endsection
