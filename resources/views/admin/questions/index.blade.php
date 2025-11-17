@extends('layouts.admin')

@section('title', 'Questions')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Questions</h1>
        <p>Manage all game questions organized by category</p>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <h2>All Questions ({{ $questions->count() }})</h2>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <a href="{{ route('admin.questions.create') }}" class="btn btn-success">+ Add Question</a>
                <select id="categoryFilter" onchange="filterQuestions()" style="padding: 8px 12px; border-radius: 5px; border: 1px solid #ddd;">
                    <option value="">All Categories</option>
                    @foreach($questions->pluck('category')->unique() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select id="pointsFilter" onchange="filterQuestions()" style="padding: 8px 12px; border-radius: 5px; border: 1px solid #ddd;">
                    <option value="">All Points</option>
                    <option value="200">$200</option>
                    <option value="400">$400</option>
                    <option value="600">$600</option>
                    <option value="800">$800</option>
                    <option value="1000">$1000</option>
                </select>
                <select id="imageFilter" onchange="filterQuestions()" style="padding: 8px 12px; border-radius: 5px; border: 1px solid #ddd;">
                    <option value="">All Images</option>
                    <option value="no_question_image">No Question Image</option>
                    <option value="no_answer_image">No Answer Image</option>
                    <option value="no_images">No Images At All</option>
                    <option value="has_both">Has Both Images</option>
                </select>
            </div>
        </div>

        @if($questions->count() > 0)
            <div class="question-bank-grid">
                @php
                    $groupedQuestions = $questions->groupBy('category_id');
                @endphp
                
                @foreach($groupedQuestions as $categoryId => $categoryQuestions)
                    @php
                        $category = $categoryQuestions->first()->category;
                    @endphp
                    <div class="category-section" data-category-id="{{ $category->id }}">
                        <div class="category-title">
                            <h3>{{ $category->name }}</h3>
                            <span class="question-count">{{ $categoryQuestions->count() }} questions</span>
                        </div>
                        
                        <div class="question-items-container">
                        @foreach($categoryQuestions->sortBy('points') as $question)
                            <div class="question-item" 
                                 data-question-id="{{ $question->id }}"
                                 data-category-id="{{ $category->id }}" 
                                 data-points="{{ $question->points }}"
                                 data-has-question-image="{{ $question->image_path ? '1' : '0' }}"
                                 data-has-answer-image="{{ $question->answer_image_path ? '1' : '0' }}">
                                <div class="question-header">
                                    <span class="points-badge drag-handle" style="cursor: move;" title="Drag to reorder">⋮⋮ ${{ $question->points }}</span>
                                    <div class="question-actions">
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="btn-icon" title="Edit">✏️</a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon delete" title="Delete">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="question-content">
                                    <div class="question-text">
                                        <strong>Q:</strong> {{ $question->question }}
                                    </div>
                                    <div class="answer-text">
                                        <strong>A:</strong> {{ $question->answer }}
                                    </div>
                                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                        @if($question->image_path)
                                            <div class="question-image-preview">
                                                <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px;">Question Image:</p>
                                                <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question image">
                                            </div>
                                        @endif
                                        @if($question->answer_image_path)
                                            <div class="question-image-preview">
                                                <p style="font-size: 12px; color: #27ae60; margin-bottom: 5px;">Answer Image:</p>
                                                <img src="{{ asset('storage/' . $question->answer_image_path) }}" alt="Answer image">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #7f8c8d; text-align: center; padding: 40px;">
                No questions yet. <a href="{{ route('admin.questions.create') }}">Create your first question</a>
            </p>
        @endif
    </div>
</div>

<style>
    .question-bank-grid {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .category-section {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        background: #f8f9fa;
    }
    
    .category-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #3498db;
    }
    
    .category-title h3 {
        color: #2c3e50;
        font-size: 24px;
        margin: 0;
    }
    
    .question-count {
        background: #3498db;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
    }
    
    .question-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    
    .question-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .sortable-ghost {
        opacity: 0.4;
        background: #e3f2fd;
    }
    
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .points-badge {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 16px;
    }
    
    .question-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-icon {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 5px 10px;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-icon:hover {
        transform: scale(1.2);
    }
    
    .btn-icon.delete:hover {
        filter: brightness(1.2);
    }
    
    .question-content {
        padding-top: 12px;
        border-top: 1px solid #e9ecef;
    }
    
    .question-text {
        margin-bottom: 10px;
        font-size: 15px;
        color: #2c3e50;
        line-height: 1.6;
    }
    
    .answer-text {
        font-size: 15px;
        color: #27ae60;
        font-weight: 500;
        line-height: 1.6;
        margin-bottom: 10px;
    }
    
    .question-image-preview {
        margin-top: 12px;
    }
    
    .question-image-preview img {
        max-width: 300px;
        max-height: 200px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .category-section.hidden {
        display: none;
    }
    
    .question-item.hidden {
        display: none;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    function filterQuestions() {
        const categoryFilter = document.getElementById('categoryFilter').value;
        const pointsFilter = document.getElementById('pointsFilter').value;
        const imageFilter = document.getElementById('imageFilter').value;
        
        const categorySections = document.querySelectorAll('.category-section');
        const questionItems = document.querySelectorAll('.question-item');
        
        // First, show all
        categorySections.forEach(section => section.classList.remove('hidden'));
        questionItems.forEach(item => item.classList.remove('hidden'));
        
        // Apply category filter
        if (categoryFilter) {
            categorySections.forEach(section => {
                if (section.dataset.categoryId !== categoryFilter) {
                    section.classList.add('hidden');
                }
            });
        }
        
        // Apply points filter
        if (pointsFilter) {
            questionItems.forEach(item => {
                if (item.dataset.points !== pointsFilter) {
                    item.classList.add('hidden');
                }
            });
        }
        
        // Apply image filter
        if (imageFilter) {
            questionItems.forEach(item => {
                const hasQuestionImage = item.dataset.hasQuestionImage === '1';
                const hasAnswerImage = item.dataset.hasAnswerImage === '1';
                
                let shouldHide = false;
                if (imageFilter === 'no_question_image' && hasQuestionImage) shouldHide = true;
                if (imageFilter === 'no_answer_image' && hasAnswerImage) shouldHide = true;
                if (imageFilter === 'no_images' && (hasQuestionImage || hasAnswerImage)) shouldHide = true;
                if (imageFilter === 'has_both' && (!hasQuestionImage || !hasAnswerImage)) shouldHide = true;
                
                if (shouldHide) {
                    item.classList.add('hidden');
                }
            });
        }
        
        // Hide empty categories
        categorySections.forEach(section => {
            const visibleQuestions = section.querySelectorAll('.question-item:not(.hidden)');
            if (visibleQuestions.length === 0 && (categoryFilter || pointsFilter || imageFilter)) {
                section.classList.add('hidden');
            }
        });
    }
    
    // Initialize drag-and-drop for each category section
    document.addEventListener('DOMContentLoaded', function() {
        const categorySections = document.querySelectorAll('.category-section');
        
        categorySections.forEach(section => {
            const container = section.querySelector('.question-items-container');
            if (!container) return;
            
            new Sortable(container, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    // Get all items in new order
                    const items = Array.from(container.querySelectorAll('.question-item'));
                    const standardPoints = [200, 400, 600, 800, 1000];
                    
                    // Update point values based on position
                    items.forEach((item, index) => {
                        const questionId = item.dataset.questionId;
                        const newPoints = standardPoints[index] || (200 + index * 200);
                        
                        // Update visually
                        const badge = item.querySelector('.points-badge');
                        badge.textContent = '⋮⋮ $' + newPoints;
                        item.dataset.points = newPoints;
                        
                        // Send AJAX request to update in database
                        fetch('/admin/questions/' + questionId + '/update-points', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
                            },
                            body: JSON.stringify({ points: newPoints })
                        });
                    });
                }
            });
        });
    });
</script>
@endsection
