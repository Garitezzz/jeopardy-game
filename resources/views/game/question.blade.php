<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question->category->name }} - ${{ $question->points }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            background: linear-gradient(135deg, #0200D4 0%, #1a1d3a 50%, #0a0e27 100%);
            color: #FFDD55;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 221, 85, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        .question-container {
            max-width: 1000px;
            width: 100%;
            text-align: center;
            background: rgba(2, 0, 212, 0.3);
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 221, 85, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .category {
            font-size: 32px;
            text-transform: uppercase;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            animation: slideDown 0.6s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .value {
            font-size: 64px;
            color: #fff;
            margin-bottom: 50px;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(255, 221, 85, 0.5);
            animation: scaleIn 0.8s ease-out 0.2s both;
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .question-text {
            font-size: 48px;
            line-height: 1.4;
            margin-bottom: 50px;
            color: #FFDD55;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            animation: fadeInUp 1s ease-out 0.4s both;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .question-image {
            max-width: 100%;
            max-height: 500px;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }
        
        .question-video,
        .answer-video {
            max-width: 100%;
            max-height: 500px;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }
        
        .question-audio,
        .answer-audio {
            width: 100%;
            margin: 20px 0;
        }
        
        .answer-section {
            margin-top: 50px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            display: none;
            border: 2px solid rgba(0, 255, 0, 0.3);
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.2);
        }
        
        .answer-media {
            margin-top: 20px;
        }
        
        .answer-image {
            max-width: 100%;
            max-height: 400px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 255, 0, 0.3);
        }
        
        .answer-section.show {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        .answer-label {
            font-size: 24px;
            color: #fff;
            margin-bottom: 20px;
        }
        
        .answer-text {
            font-size: 42px;
            color: #00ff00;
            line-height: 1.4;
        }
        
        .controls {
            margin-top: 50px;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 1.2s ease-out 0.6s both;
        }
        
        .btn {
            padding: 20px 40px;
            border: none;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Arial Black', Arial, sans-serif;
        }
        
        .btn-reveal {
            background: #FFDD55;
            color: #0200D4;
        }
        
        .btn-reveal:hover {
            background: #ffed4e;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(255, 221, 85, 0.4);
        }
        
        .btn-back {
            background: #27ae60;
            color: white;
        }
        
        .btn-back:hover {
            background: #229954;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .category {
                font-size: 24px;
            }
            
            .value {
                font-size: 48px;
            }
            
            .question-text {
                font-size: 32px;
            }
            
            .answer-text {
                font-size: 28px;
            }
            
            .btn {
                padding: 15px 30px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="question-container">
        <div class="category">{{ $question->category->name }}</div>
        <div class="value">${{ $question->points }}</div>
        
        <div class="question-text">{{ $question->question }}</div>
        
        @if($question->image_path)
            <img src="{{ asset('storage/' . $question->image_path) }}" class="question-image" alt="Question image">
        @endif
        
        @if($question->video_path)
            <video controls class="question-video">
                <source src="{{ asset('storage/' . $question->video_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif
        
        @if($question->audio_path)
            <audio controls class="question-audio">
                <source src="{{ asset('storage/' . $question->audio_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        @endif
        
        <div class="answer-section" id="answerSection">
            <div class="answer-label">ANSWER:</div>
            <div class="answer-text">{{ $question->answer }}</div>
            
            <div class="answer-media">
                @if($question->answer_image_path)
                    <img src="{{ asset('storage/' . $question->answer_image_path) }}" class="answer-image" alt="Answer image">
                @endif
                
                @if($question->answer_video_path)
                    <video controls class="answer-video">
                        <source src="{{ asset('storage/' . $question->answer_video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
                
                @if($question->answer_audio_path)
                    <audio controls class="answer-audio">
                        <source src="{{ asset('storage/' . $question->answer_audio_path) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                @endif
            </div>
        </div>
        
        <div class="controls">
            <button class="btn btn-reveal" id="revealBtn" onclick="revealAnswer()">Reveal Answer</button>
            <a href="/" class="btn btn-back">Back to Board</a>
        </div>
    </div>
    
    <script>
        function revealAnswer() {
            document.getElementById('answerSection').classList.add('show');
            document.getElementById('revealBtn').style.display = 'none';
            
            // Mark question as used in localStorage
            const questionId = {{ $question->id }};
            let usedQuestions = JSON.parse(localStorage.getItem('usedQuestions') || '[]');
            if (!usedQuestions.includes(questionId)) {
                usedQuestions.push(questionId);
                localStorage.setItem('usedQuestions', JSON.stringify(usedQuestions));
            }
        }
    </script>
</body>
</html>
