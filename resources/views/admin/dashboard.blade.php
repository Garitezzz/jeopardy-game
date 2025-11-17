@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Manage your Jeopardy game content</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Categories</h3>
        <div class="number">{{ $categories->count() }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #27ae60;">
        <h3>Total Questions</h3>
        <div class="number">{{ $totalQuestions }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #f39c12;">
        <h3>Avg Questions/Category</h3>
        <div class="number">{{ $categories->count() > 0 ? round($totalQuestions / $categories->count(), 1) : 0 }}</div>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px;">Quick Actions</h2>
    <div class="action-buttons">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-success">+ Add Question</a>
        <a href="{{ route('admin.questions.index') }}" class="btn" style="background: #16a085; color: white;">📋 View All Questions</a>
        <a href="{{ route('admin.settings') }}" class="btn" style="background: #9b59b6; color: white;">⚙️ Game Settings</a>
        <a href="{{ route('game.board') }}" class="btn btn-warning">🎮 View Game Board</a>
        <a href="{{ route('admin.export') }}" class="btn btn-secondary">📥 Export JSON</a>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px;">Import Data</h2>
    <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
        @csrf
        <div class="form-group">
            <label>Option 1: Upload JSON File</label>
            <input type="file" name="json_file" accept=".json" class="form-control" id="jsonFile">
        </div>
        
        <div class="form-group" style="margin-top: 20px;">
            <label>Option 2: Paste JSON Code Directly</label>
            <textarea name="json_code" id="jsonCode" class="form-control" rows="8" placeholder='Paste your JSON here...' style="font-family: monospace; font-size: 13px;"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Import Data</button>
        <button type="button" onclick="toggleExample()" class="btn" style="background: #95a5a6; color: white; margin-left: 10px;">📋 View JSON Example</button>
        <p style="margin-top: 10px; color: #7f8c8d; font-size: 14px;">⚠️ Warning: This will replace all existing data!</p>
        
        <div id="jsonExample" style="display: none; margin-top: 20px; padding: 15px; background: #2c3e50; color: #ecf0f1; border-radius: 5px; overflow-x: auto;">
            <strong style="color: #f39c12;">JSON Format Example:</strong>
            <pre style="margin: 10px 0; font-size: 12px; line-height: 1.6;">{
  "categories": [
    {
      "name": "Science",
      "order": 1,
      "questions": [
        {
          "question": "What is H2O?",
          "answer": "Water",
          "points": 200,
          "difficulty": "easy"
        },
        {
          "question": "What planet is closest to the sun?",
          "answer": "Mercury",
          "points": 400,
          "difficulty": "medium"
        }
      ]
    },
    {
      "name": "History",
      "order": 2,
      "questions": [
        {
          "question": "Who was the first president?",
          "answer": "George Washington",
          "points": 200,
          "difficulty": "easy"
        }
      ]
    }
  ]
}</pre>
            <p style="margin-top: 10px; color: #bdc3c7; font-size: 13px;">💡 Tip: Questions must be nested inside their category. Point values: 200, 400, 600, 800, 1000</p>
        </div>
    </form>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px;">Categories Overview</h2>
    @if($categories->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Category Name</th>
                    <th>Questions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->order }}</td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->questions_count }} questions</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                            @if($category->questions_count > 0)
                            <button onclick="toggleQuestions({{ $category->id }})" class="btn" style="background: #3498db; color: white;">View</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @if($category->questions_count > 0)
                <tr id="questions-{{ $category->id }}" style="display: none;">
                    <td colspan="4" style="background: #ecf0f1; padding: 15px;">
                        <strong>Questions in {{ $category->name }}:</strong>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            @foreach($category->questions as $question)
                            <li style="margin: 5px 0;">
                                <strong>${{ $question->points }}</strong> - {{ Str::limit($question->question, 80) }}
                                <span style="color: #7f8c8d; font-size: 12px;">({{ $question->difficulty }})</span>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #7f8c8d;">No categories yet. <a href="{{ route('admin.categories.create') }}">Create your first category</a></p>
    @endif
</div>

<script>
function toggleQuestions(categoryId) {
    const row = document.getElementById('questions-' + categoryId);
    if (row.style.display === 'none') {
        row.style.display = 'table-row';
    } else {
        row.style.display = 'none';
    }
}

function toggleExample() {
    const example = document.getElementById('jsonExample');
    if (example.style.display === 'none') {
        example.style.display = 'block';
    } else {
        example.style.display = 'none';
    }
}

// Make file and textarea mutually optional
document.getElementById('importForm').addEventListener('submit', function(e) {
    const file = document.getElementById('jsonFile').files[0];
    const code = document.getElementById('jsonCode').value.trim();
    
    if (!file && !code) {
        e.preventDefault();
        alert('Please either upload a JSON file or paste JSON code.');
        return false;
    }
});
</script>
@endsection
