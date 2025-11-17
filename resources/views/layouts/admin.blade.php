<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Jeopardy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%);
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 2px solid #34495e;
            margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, transparent 100%);
            padding-bottom: 25px;
        }
        
        .sidebar-header h2 {
            color: #ffd700;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-nav {
            list-style: none;
        }
        
        .sidebar-nav a {
            display: block;
            padding: 14px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 15px;
            font-weight: 500;
        }
        
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(52, 73, 94, 0.8) 0%, rgba(52, 73, 94, 0.3) 100%);
            border-left: 4px solid #ffd700;
            padding-left: 20px;
            color: #ffd700;
            transform: translateX(2px);
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 5px solid #3498db;
        }
        
        .page-header h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-warning:hover {
            background: #e67e22;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .card {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 35px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        
        table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 5px solid #3498db;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            transform: translateY(-3px);
        }
        
        .stat-card h3 {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        
        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload:hover {
            border-color: #3498db;
            background: #f8f9fa;
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
        
        .draggable {
            cursor: move;
        }
        
        .dragging {
            opacity: 0.5;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>🎯 Jeopardy Admin</h2>
            </div>
            <nav>
                <ul class="sidebar-nav">
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">📁 Categories</a></li>
                    <li><a href="{{ route('admin.questions.index') }}" class="{{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">❓ Questions</a></li>
                    <li><a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ Settings</a></li>
                    <li><a href="{{ route('game.index') }}">🎮 View Game Board</a></li>
                    <li><a href="{{ route('admin.export') }}">📥 Export Data</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
    
    @yield('scripts')
</body>
</html>
