{{--
    Game Rules View
    
    Displays Jeopardy game rules and instructions for players.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy Rules</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1d3a 50%, #0200D4 100%);
            color: #fff;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .rules-container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(30, 60, 114, 0.4);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            border: 3px solid #FFDD55;
            backdrop-filter: blur(10px);
        }
        
        h1 {
            color: #FFDD55;
            text-align: center;
            font-size: 48px;
            margin-bottom: 40px;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8);
            letter-spacing: 2px;
        }
        
        .rules-content {
            font-family: Arial, sans-serif;
            font-size: 18px;
            line-height: 1.8;
            color: #fff;
        }
        
        .rules-content h2 {
            color: #FFDD55;
            font-size: 28px;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .rules-content ul {
            margin-left: 30px;
            margin-bottom: 20px;
        }
        
        .rules-content li {
            margin-bottom: 12px;
        }
        
        .rules-content p {
            margin-bottom: 15px;
        }
        
        .back-button {
            display: inline-block;
            margin-top: 40px;
            padding: 15px 40px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .back-button:hover {
            background: #229954;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }
        
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="rules-container">
        <h1>JEOPARDY! RULES</h1>
        
        <div class="rules-content">
            {!! $rules ?? '<h2>Game Rules</h2>
            <ul>
                <li><strong>Selecting Questions:</strong> Click on any dollar amount tile to reveal a question.</li>
                <li><strong>Reading Questions:</strong> Read the question carefully. All questions are in the form of answers.</li>
                <li><strong>Answering:</strong> Your response must be phrased in the form of a question (e.g., "What is...?" or "Who is...?").</li>
                <li><strong>Scoring:</strong> Correct answers add the dollar amount to your score. Incorrect answers subtract the amount.</li>
                <li><strong>Used Questions:</strong> Once a question is answered, it becomes unavailable for the rest of the game.</li>
                <li><strong>Player Turns:</strong> Click on a player card to set them as the active player.</li>
                <li><strong>Score Adjustments:</strong> Use the +$100 and -$100 buttons, or type directly in the score field.</li>
                <li><strong>Final Jeopardy:</strong> Use the "Overtime / Final Round" button for the final question.</li>
            </ul>
            
            <h2>Game Controls</h2>
            <ul>
                <li><strong>Reset Board:</strong> Makes all questions available again.</li>
                <li><strong>Reset Scores:</strong> Sets all player scores back to $0.</li>
                <li><strong>Player Names:</strong> Click on any player name to edit it.</li>
                <li><strong>Game Title:</strong> Click on the main title to edit it.</li>
            </ul>
            
            <h2>Tips for Players</h2>
            <ul>
                <li>Strategy matters! Higher value questions are typically harder.</li>
                <li>Keep track of categories you\'re strong in.</li>
                <li>In Final Jeopardy, you can wager any amount up to your total score.</li>
            </ul>' !!}
        </div>
        
        <div class="button-container">
            <a href="/" class="back-button">Back to Game Board</a>
        </div>
    </div>
</body>
</html>
