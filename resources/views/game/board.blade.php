{{--
    Game Board View
    
    Main Jeopardy game board displaying categories and questions.
    Features:
    - Dynamic 6-column board layout
    - Modal question/answer display
    - 4-player scoreboard with manual score controls
    - Sound effects for clicks and reveals
    - LocalStorage persistence for game state
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jeopardy Game Board</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a1d3a;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #FFDD55 0%, #f39c12 100%);
            border-radius: 10px;
            border: 2px solid #1a1d3a;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #ffed4e 0%, #e67e22 100%);
        }
        
        body {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            background: #0a0e27;
            color: #fff;
            overflow: hidden;
        }
        
        .game-container {
            display: flex;
            height: 100vh;
            padding: 0;
            gap: 0;
            overflow: hidden;
        }
        
        .board-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 10px;
        }
        
        .board-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            justify-content: flex-start;
        }
        
        .scoreboard-section {
            width: 320px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
            padding: 10px;
            background: #0a0e27;
        }
        
        .game-header {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .game-header input {
            background: transparent;
            border: none;
            color: #FFDD55;
            font-size: 38px;
            font-family: 'Arial Black', Arial, sans-serif;
            text-align: center;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8);
            width: 100%;
            padding: 5px;
        }
        
        .game-header input:focus {
            outline: 2px dashed #FFDD55;
            background: rgba(2, 0, 212, 0.2);
            border-radius: 5px;
        }
        
        .controls-toggle {
            background: linear-gradient(135deg, #FFDD55 0%, #f39c12 100%);
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 221, 85, 0.5);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .controls-toggle:hover {
            background: linear-gradient(135deg, #ffed4e 0%, #e67e22 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 221, 85, 0.5);
        }
        
        .categories-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 5px;
            margin-bottom: 5px;
        }
        
        .category-header {
            background: linear-gradient(135deg, #0200D4 0%, #0300ff 100%);
            padding: 10px 8px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #FFDD55;
            border-radius: 8px;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 221, 85, 0.3);
            transition: all 0.3s;
        }
        
        .category-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.7), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .questions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 5px;
            flex: 1;
        }
        
        .question-tile {
            background: linear-gradient(135deg, #0200D4 0%, #1e3c72 100%);
            padding: 12px;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #FFDD55;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6), inset 0 2px 0 rgba(255, 255, 255, 0.1);
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 221, 85, 0.2);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .question-tile::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 221, 85, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .question-tile:hover:not(.used) {
            transform: scale(1.08) translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 221, 85, 0.5), 0 0 30px rgba(2, 0, 212, 0.6);
            background: linear-gradient(135deg, #0300ff 0%, #2a5298 100%);
            border-color: #FFDD55;
        }
        
        .question-tile:hover:not(.used)::before {
            left: 100%;
        }
        
        .question-tile.used {
            background: #1a1d3a;
            color: #444;
            cursor: not-allowed;
            opacity: 0.4;
        }
        
        .player-card {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            border: 2px solid #FFDD55;
        }
        
        .player-card.active {
            border-color: #00ff00;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
        }
        
        .player-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .player-name {
            font-size: 16px;
            font-weight: bold;
            color: #FFDD55;
        }
        
        .player-name input {
            background: transparent;
            border: none;
            border-bottom: 2px solid #FFDD55;
            color: #FFDD55;
            font-size: 16px;
            font-weight: bold;
            width: 130px;
            padding: 3px 0;
        }
        
        .player-score {
            font-size: 26px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            margin: 8px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .player-score input {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            width: 110px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            font-family: 'Arial Black', Arial, sans-serif;
        }
        
        .player-score input:focus {
            outline: 2px dashed #FFDD55;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        
        .score-controls {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        
        .score-btn {
            padding: 6px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
        }
        
        .score-btn.add {
            background: #27ae60;
            color: white;
        }
        
        .score-btn.add:hover {
            background: #229954;
        }
        
        .score-btn.subtract {
            background: #e74c3c;
            color: white;
        }
        
        .score-btn.subtract:hover {
            background: #c0392b;
        }
        
        .game-controls {
            background: linear-gradient(135deg, #1a1d3a 0%, #2a2d4a 100%);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            display: none;
            border: 2px solid rgba(255, 221, 85, 0.2);
        }
        
        .game-controls.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .game-controls h3 {
            color: #FFDD55;
            margin-bottom: 12px;
            font-size: 16px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .control-btn {
            width: 100%;
            padding: 10px;
            margin-bottom: 8px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
            color: white;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
            border: 2px solid transparent;
        }
        
        .control-btn.reset {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        
        .control-btn.reset:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(231, 76, 60, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .control-btn.overtime {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }
        
        .control-btn.overtime:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(243, 156, 18, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .control-btn.admin {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        }
        
        .control-btn.admin:hover {
            background: linear-gradient(135deg, #8e44ad 0%, #7d3c98 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(155, 89, 182, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .control-btn.rules {
            background: linear-gradient(135deg, #16a085 0%, #138d75 100%);
        }
        
        .control-btn.rules:hover {
            background: linear-gradient(135deg, #138d75 0%, #117a65 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(22, 160, 133, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .control-btn.main {
            background: linear-gradient(135deg, #2980b9 0%, #2471a3 100%);
        }
        
        .control-btn.main:hover {
            background: linear-gradient(135deg, #2471a3 0%, #1f618d 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(41, 128, 185, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            animation: fadeIn 0.3s;
        }
        
        .info-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        
        .info-modal.active {
            display: flex;
        }
        
        .info-modal-content {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 40px;
            border-radius: 15px;
            max-width: 600px;
            width: 90%;
            position: relative;
            animation: slideDown 0.4s;
            border: 3px solid #FFDD55;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8);
        }
        
        .info-modal-header {
            font-size: 28px;
            color: #FFDD55;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .info-modal-body {
            color: #fff;
            font-size: 16px;
            line-height: 1.8;
            text-align: left;
            font-family: Arial, sans-serif;
        }
        
        .info-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 30px;
            color: #FFDD55;
            cursor: pointer;
            font-weight: bold;
        }
        
        .info-modal-close:hover {
            color: #ffed4e;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: #0200D4;
            padding: 50px;
            border-radius: 15px;
            max-width: 800px;
            width: 90%;
            text-align: center;
            position: relative;
            animation: slideDown 0.4s;
        }
        
        .modal-content.show-answer {
            background: #1e3c72;
        }
        
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: #FFDD55;
            cursor: pointer;
            font-weight: bold;
        }
        
        .modal-category {
            color: #FFDD55;
            font-size: 24px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        
        .modal-value {
            color: #fff;
            font-size: 48px;
            margin-bottom: 30px;
        }
        
        .modal-question {
            color: #FFDD55;
            font-size: 32px;
            line-height: 1.4;
            margin-bottom: 30px;
        }
        
        .modal-answer {
            color: #00ff00;
            font-size: 36px;
            margin-top: 30px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }
        
        .answer-section {
            display: none;
            margin-top: 30px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            border: 2px solid rgba(255, 221, 85, 0.3);
        }
        
        .answer-section.show {
            display: block;
        }
        
        .answer-label {
            color: #FFFFFF;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            letter-spacing: 2px;
        }
        
        .answer-text {
            color: #00ff00;
            font-size: 36px;
            line-height: 1.4;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .answer-media {
            margin-top: 25px;
            text-align: center;
        }
        
        .modal-image {
            max-width: 100%;
            max-height: 400px;
            margin: 20px 0;
            border-radius: 10px;
        }
        
        .modal-btn {
            padding: 15px 40px;
            background: #FFDD55;
            color: #0200D4;
            border: none;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            margin: 10px;
            transition: all 0.3s;
        }
        
        .modal-btn:hover {
            background: #ffed4e;
            transform: scale(1.05);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideDown {
            from { 
                transform: translateY(-50px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @media (max-width: 1200px) {
            .scoreboard-section {
                width: 280px;
            }
        }
        
        @media (max-width: 992px) {
            .game-container {
                flex-direction: column;
            }
            
            .scoreboard-section {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .player-card {
                flex: 1;
                min-width: 230px;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="board-section">
            <div class="game-header">
                <input type="text" id="game-title" value="JEOPARDY!" onclick="this.select()">
            </div>
            
            <div class="board-wrapper">
            <div class="categories-row">
                @foreach($categories as $category)
                    <div class="category-header">{{ $category->name }}</div>
                @endforeach
            </div>
            
            @php
                $maxQuestions = $categories->max(function($cat) { return $cat->questions->count(); });
                $pointValues = [200, 400, 600, 800, 1000];
            @endphp
            
            @for($row = 0; $row < 5; $row++)
                <div class="questions-grid" style="margin-bottom: 5px;">
                    @foreach($categories as $category)
                        @php
                            $question = $category->questions->where('points', $pointValues[$row])->first();
                        @endphp
                        @if($question)
                            <div class="question-tile" data-id="{{ $question->id }}" onclick="goToQuestion({{ $question->id }})">
                                ${{ $question->points }}
                            </div>
                        @else
                            <div class="question-tile used"></div>
                        @endif
                    @endforeach
                </div>
            @endfor
            </div>
        </div>
        
        <div class="scoreboard-section">
            <h2 style="text-align: center; color: #FFDD55; font-size: 24px; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Scoreboard</h2>
            @for($i = 1; $i <= 4; $i++)
                <div class="player-card" id="player-{{ $i }}" onclick="setActivePlayer({{ $i }})">
                    <div class="player-header">
                        <div class="player-name">
                            <input type="text" value="Player {{ $i }}" id="player-name-{{ $i }}">
                        </div>
                    </div>
                    <div class="player-score">
                        <input type="number" id="score-{{ $i }}" value="0" onchange="updateScoreFromInput({{ $i }})" onclick="event.stopPropagation()">
                    </div>
                    <div class="score-controls">
                        <button class="score-btn subtract" onclick="adjustScore({{ $i }}, -200); event.stopPropagation();">-$200</button>
                        <button class="score-btn add" onclick="adjustScore({{ $i }}, 200); event.stopPropagation();">+$200</button>
                    </div>
                </div>
            @endfor
            
            <div class="controls-toggle" onclick="toggleControls()">⚙️ Controls</div>
            
            <div class="game-controls" id="gameControls">
                <h3>Game Controls</h3>
                <button class="control-btn main" onclick="window.location.href='/main-title'">Main Title Screen</button>
                <button class="control-btn rules" onclick="window.location.href='/rules'">Rules</button>
                <a href="{{ route('admin.dashboard') }}" class="control-btn admin" style="display: block; text-align: center; text-decoration: none; line-height: 1.5;">Admin Panel</a>
                <button class="control-btn reset" onclick="confirmReset('board')">Reset Board</button>
                <button class="control-btn reset" onclick="confirmReset('scores')">Reset Scores</button>
            </div>
        </div>
    </div>
    
    <div id="questionModal" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div class="modal-category" id="modalCategory"></div>
            <div class="modal-value" id="modalValue"></div>
            <div class="modal-question" id="modalQuestion"></div>
            <div id="modalImageContainer"></div>
            <div class="answer-section" id="answerSection">
                <div class="answer-label">ANSWER:</div>
                <div class="answer-text" id="answerText"></div>
                <div class="answer-media" id="answerMediaContainer"></div>
            </div>
            <button class="modal-btn" id="revealBtn" onclick="revealAnswer()">Reveal Answer</button>
        </div>
    </div>
    
    <div id="infoModal" class="info-modal">
        <div class="info-modal-content">
            <span class="info-modal-close" onclick="closeInfoModal()">&times;</span>
            <div class="info-modal-header" id="infoModalTitle"></div>
            <div class="info-modal-body" id="infoModalBody"></div>
        </div>
    </div>
    
    <!-- Hidden audio elements for sound effects -->
    <audio id="clickSound" preload="auto" crossorigin="anonymous">
        <source src="/sounds/click.wav" type="audio/wav">
        <source src="/sounds/click.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <audio id="revealSound" preload="auto" crossorigin="anonymous">
        <source src="/sounds/reveal.wav" type="audio/wav">
        <source src="/sounds/reveal.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    
    <script>
        // Sound effect player with better error handling
        function playSound(type) {
            try {
                const sound = document.getElementById(type + 'Sound');
                if (sound) {
                    sound.currentTime = 0;
                    const playPromise = sound.play();
                    
                    if (playPromise !== undefined) {
                        playPromise
                            .then(() => {
                                console.log(`${type} sound played successfully`);
                            })
                            .catch(error => {
                                console.error(`${type} sound play failed:`, error);
                                // Try to enable audio on user interaction
                                if (error.name === 'NotAllowedError') {
                                    console.log('Audio playback requires user interaction first');
                                }
                            });
                    }
                }
            } catch (e) {
                console.error('Sound error:', e);
            }
        }
        
        // Enable audio on first user interaction
        let audioEnabled = false;
        function enableAudio() {
            if (!audioEnabled) {
                const clickSound = document.getElementById('clickSound');
                const revealSound = document.getElementById('revealSound');
                
                if (clickSound && revealSound) {
                    clickSound.volume = 0.5;
                    revealSound.volume = 0.5;
                    
                    // Preload by playing and pausing
                    clickSound.play().then(() => clickSound.pause()).catch(() => {});
                    revealSound.play().then(() => revealSound.pause()).catch(() => {});
                    
                    audioEnabled = true;
                    console.log('Audio enabled');
                }
            }
        }
        
        // Enable audio on any click
        document.addEventListener('click', enableAudio, { once: false });
        
        const questions = @json($categories->flatMap->questions);
        let currentQuestion = null;
        let playerScores = [0, 0, 0, 0];
        let activePlayer = 1;
        let usedQuestions = JSON.parse(localStorage.getItem('usedQuestions') || '[]');
        let controlsVisible = false;
        
        // Load saved data
        window.addEventListener('load', function() {
            const savedScores = JSON.parse(localStorage.getItem('playerScores') || '[0,0,0,0]');
            const savedNames = JSON.parse(localStorage.getItem('playerNames') || '["Player 1","Player 2","Player 3","Player 4"]');
            const savedTitle = localStorage.getItem('gameTitle') || 'JEOPARDY!';
            
            playerScores = savedScores;
            document.getElementById('game-title').value = savedTitle;
            
            savedNames.forEach((name, i) => {
                document.getElementById(`player-name-${i+1}`).value = name;
                document.getElementById(`score-${i+1}`).value = savedScores[i];
            });
            
            usedQuestions.forEach(id => {
                const tile = document.querySelector(`[data-id="${id}"]`);
                if (tile) tile.classList.add('used');
            });
            
            setActivePlayer(1);
            
            // Set audio volume
            const clickSound = document.getElementById('clickSound');
            const revealSound = document.getElementById('revealSound');
            if (clickSound) clickSound.volume = 0.5;
            if (revealSound) revealSound.volume = 0.5;
        });
        
        // Save game title
        document.getElementById('game-title').addEventListener('change', function() {
            localStorage.setItem('gameTitle', this.value);
        });
        
        // Save player names
        for (let i = 1; i <= 4; i++) {
            document.getElementById(`player-name-${i}`).addEventListener('change', function() {
                const names = [];
                for (let j = 1; j <= 4; j++) {
                    names.push(document.getElementById(`player-name-${j}`).value);
                }
                localStorage.setItem('playerNames', JSON.stringify(names));
            });
        }
        
        function goToQuestion(id) {
            const tile = event.target;
            if (tile.classList.contains('used')) return;
            
            // Don't mark as used yet - only when answer is revealed
            // Navigate to question page
            window.location.href = `/question/${id}`;
        }
        
        function showRules() {
            alert('JEOPARDY RULES:\n\n1. Select a question from the board\n2. Read the question carefully\n3. Buzz in to answer\n4. Answer must be in the form of a question\n5. Correct answer adds points, incorrect answer subtracts points\n6. The player with the most points wins!');
        }
        
        function showQuestion(id) {
            const tile = event.target;
            if (tile.classList.contains('used')) return;
            
            const question = questions.find(q => q.id === id);
            if (!question) return;
            
            // Enable audio if not already enabled
            enableAudio();
            
            // Mark as used immediately
            tile.classList.add('used');
            usedQuestions.push(id);
            localStorage.setItem('usedQuestions', JSON.stringify(usedQuestions));
            
            // Store the entire question object
            currentQuestion = {
                id: question.id,
                question: question.question,
                answer: question.answer,
                points: question.points,
                category: question.category,
                image_path: question.image_path,
                answer_image_path: question.answer_image_path,
                answer_video_path: question.answer_video_path,
                answer_audio_path: question.answer_audio_path,
                video_path: question.video_path,
                audio_path: question.audio_path
            };
            
            document.getElementById('modalCategory').textContent = currentQuestion.category.name;
            document.getElementById('modalValue').textContent = '$' + currentQuestion.points;
            document.getElementById('modalQuestion').textContent = currentQuestion.question;
            document.getElementById('modalAnswer').innerHTML = currentQuestion.answer;
            document.getElementById('modalAnswer').style.display = 'none';
            document.getElementById('revealBtn').style.display = 'block';
            document.getElementById('modalContent').classList.remove('show-answer');
            
            // Handle question image
            const imageContainer = document.getElementById('modalImageContainer');
            if (currentQuestion.image_path) {
                imageContainer.innerHTML = `<img src="/storage/${currentQuestion.image_path}" class="modal-image" alt="Question image">`;
            } else {
                imageContainer.innerHTML = '';
            }
            
            // Play click sound
            playSound('click');
            
            document.getElementById('questionModal').classList.add('active');
        }
        
        function revealAnswer() {
            const answerSection = document.getElementById('answerSection');
            const answerText = document.getElementById('answerText');
            const mediaContainer = document.getElementById('answerMediaContainer');
            
            console.log('Current Question:', currentQuestion);
            console.log('Answer Image Path:', currentQuestion.answer_image_path);
            console.log('Answer Video Path:', currentQuestion.answer_video_path);
            console.log('Answer Audio Path:', currentQuestion.answer_audio_path);
            
            // Set answer text
            answerText.innerHTML = currentQuestion.answer;
            
            // Build answer media HTML
            let mediaHTML = '';
            
            // Add answer image if it exists
            if (currentQuestion && currentQuestion.answer_image_path) {
                mediaHTML += `<img src="/storage/${currentQuestion.answer_image_path}" class="modal-image" alt="Answer image" style="margin-top: 15px;">`;
            }
            
            // Add answer video if it exists
            if (currentQuestion && currentQuestion.answer_video_path) {
                mediaHTML += `<video controls class="modal-image" style="margin-top: 15px;"><source src="/storage/${currentQuestion.answer_video_path}" type="video/mp4"></video>`;
            }
            
            // Add answer audio if it exists
            if (currentQuestion && currentQuestion.answer_audio_path) {
                mediaHTML += `<audio controls style="margin-top: 15px; width: 100%; max-width: 500px;"><source src="/storage/${currentQuestion.answer_audio_path}" type="audio/mpeg"></audio>`;
            }
            
            console.log('Media HTML:', mediaHTML);
            
            // Set media content
            mediaContainer.innerHTML = mediaHTML;
            
            // Show answer section
            answerSection.classList.add('show');
            
            document.getElementById('revealBtn').style.display = 'none';
            document.getElementById('modalContent').classList.add('show-answer');
            
            // Play reveal sound
            playSound('reveal');
        }
        
        function closeModal() {
            document.getElementById('questionModal').classList.remove('active');
            document.getElementById('answerSection').classList.remove('show');
            document.getElementById('answerMediaContainer').innerHTML = '';
        }
        
        function adjustScore(player, amount) {
            playerScores[player - 1] += amount;
            document.getElementById(`score-${player}`).value = playerScores[player - 1];
            localStorage.setItem('playerScores', JSON.stringify(playerScores));
        }
        
        function updateScoreFromInput(player) {
            const input = document.getElementById(`score-${player}`);
            playerScores[player - 1] = parseInt(input.value) || 0;
            localStorage.setItem('playerScores', JSON.stringify(playerScores));
        }
        
        function toggleControls() {
            controlsVisible = !controlsVisible;
            const controls = document.getElementById('gameControls');
            if (controlsVisible) {
                controls.classList.add('show');
            } else {
                controls.classList.remove('show');
            }
        }
        
        function setActivePlayer(player) {
            for (let i = 1; i <= 4; i++) {
                document.getElementById(`player-${i}`).classList.remove('active');
            }
            document.getElementById(`player-${player}`).classList.add('active');
            activePlayer = player;
        }
        
        function showInfoModal(title, message) {
            const modal = document.getElementById('infoModal');
            document.getElementById('infoModalTitle').textContent = title;
            document.getElementById('infoModalBody').innerHTML = message;
            modal.classList.add('active');
        }
        
        function closeInfoModal() {
            document.getElementById('infoModal').classList.remove('active');
        }
        
        function confirmReset(type) {
            if (type === 'board') {
                showInfoModal('Reset Board?', '<p style="text-align: center; font-size: 18px;">Are you sure you want to reset the entire board?<br>All answered questions will be available again.</p><div style="text-align: center; margin-top: 20px;"><button class="modal-btn" onclick="doResetBoard(); closeInfoModal();">Yes, Reset Board</button> <button class="modal-btn" style="background: #e74c3c;" onclick="closeInfoModal()">Cancel</button></div>');
            } else if (type === 'scores') {
                showInfoModal('Reset Scores?', '<p style="text-align: center; font-size: 18px;">Are you sure you want to reset all player scores to $0?</p><div style="text-align: center; margin-top: 20px;"><button class="modal-btn" onclick="doResetScores(); closeInfoModal();">Yes, Reset Scores</button> <button class="modal-btn" style="background: #e74c3c;" onclick="closeInfoModal()">Cancel</button></div>');
            }
        }
        
        function doResetBoard() {
            usedQuestions = [];
            localStorage.setItem('usedQuestions', JSON.stringify(usedQuestions));
            document.querySelectorAll('.question-tile').forEach(tile => {
                tile.classList.remove('used');
            });
        }
        
        function doResetScores() {
            playerScores = [0, 0, 0, 0];
            for (let i = 1; i <= 4; i++) {
                document.getElementById(`score-${i}`).value = 0;
            }
            localStorage.setItem('playerScores', JSON.stringify(playerScores));
        }
        
        function showOvertimeModal() {
            showInfoModal('Overtime / Final Round', '<p style="text-align: center; font-size: 18px;">Enter the Final Jeopardy round or overtime mode.</p><p style="text-align: center; margin-top: 15px; color: #FFDD55;">This feature allows you to enter custom questions for the final round!</p><div style="text-align: center; margin-top: 20px;"><button class="modal-btn" onclick="closeInfoModal()">OK</button></div>');
        }
        
        // Close modal on outside click
        document.getElementById('questionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
