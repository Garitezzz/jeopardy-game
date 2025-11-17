<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->title ?? 'JEOPARDY!' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            background: linear-gradient(135deg, #0200D4 0%, #0a0e27 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 221, 85, 0.15) 0%, transparent 70%);
            animation: pulse 10s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.5; }
            50% { transform: scale(1.1) rotate(180deg); opacity: 0.8; }
        }
        
        .main-container {
            text-align: center;
            z-index: 1;
            padding: 40px;
        }
        
        .logo-container {
            margin-bottom: 30px;
            animation: fadeInDown 1s ease-out;
        }
        
        .logo-container img {
            max-width: 500px;
            max-height: 250px;
            width: auto;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.8));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        h1 {
            font-size: 72px;
            color: #FFDD55;
            text-shadow: 5px 5px 15px rgba(0, 0, 0, 0.9), 0 0 40px rgba(255, 221, 85, 0.5);
            margin-bottom: 40px;
            letter-spacing: 8px;
            animation: fadeInScale 1.2s ease-out 0.3s both;
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .subtitle {
            font-size: 22px;
            color: #fff;
            margin-bottom: 35px;
            font-family: Arial, sans-serif;
            animation: fadeIn 1.5s ease-out 0.6s both;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .menu-buttons {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1.5s ease-out 0.9s both;
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
        
        .menu-btn {
            padding: 20px 50px;
            font-size: 22px;
            font-weight: bold;
            background: linear-gradient(135deg, #FFDD55 0%, #f39c12 100%);
            color: #0200D4;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            font-family: 'Arial Black', Arial, sans-serif;
        }
        
        .menu-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(255, 221, 85, 0.6);
            background: linear-gradient(135deg, #ffed4e 0%, #e67e22 100%);
        }
        
        .menu-btn.secondary {
            background: linear-gradient(135deg, #27ae60 0%, #16a085 100%);
            color: white;
        }
        
        .menu-btn.secondary:hover {
            background: linear-gradient(135deg, #229954 0%, #138d75 100%);
            box-shadow: 0 12px 30px rgba(39, 174, 96, 0.6);
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 48px;
                letter-spacing: 4px;
            }
            
            .logo-container img {
                max-width: 300px;
                max-height: 150px;
            }
            
            .menu-btn {
                padding: 15px 35px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        @if(isset($settings) && $settings->logo_path)
        <div class="logo-container">
            <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Jeopardy Logo">
        </div>
        @endif
        
        <h1>{{ $settings->title ?? 'JEOPARDY!' }}</h1>
        
        @if(isset($settings) && $settings->subtitle)
        <div class="subtitle">{{ $settings->subtitle }}</div>
        @endif
        
        <div class="menu-buttons">
            <a href="/" class="menu-btn">Start Game</a>
            <a href="/rules" class="menu-btn secondary">View Rules</a>
            <a href="{{ route('admin.dashboard') }}" class="menu-btn secondary">Admin Panel</a>
        </div>
    </div>
</body>
</html>
