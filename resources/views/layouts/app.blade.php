{{--
    Main Application Layout
    
    Base layout template for general game pages.
    Provides common HTML structure, styles, and scripts.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jeopardy Game')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #ffd700;
            font-size: 3em;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #ffd700;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn:hover {
            background: #ffed4e;
            transform: scale(1.05);
        }
        
        .btn-secondary {
            background: #4a90e2;
            color: #fff;
        }
        
        .btn-secondary:hover {
            background: #357abd;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #4caf50;
        }
        
        .alert-error {
            background: #f44336;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ffd700;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🎯 Jeopardy Game</h1>
            @if(isset($game))
                <p style="margin-top: 10px; font-size: 1.2em;">
                    Player: <strong>{{ $game->player_name }}</strong> | 
                    Score: <strong style="color: #ffd700;">{{ $game->score }}</strong> points
                </p>
            @endif
        </header>
        
        @yield('content')
    </div>
</body>
</html>
