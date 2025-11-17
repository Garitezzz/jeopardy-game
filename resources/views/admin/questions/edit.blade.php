@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
<div class="page-header">
    <h1>Edit Question</h1>
    <p>Update question information</p>
</div>

<div class="card">
    <form id="questionForm" action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $question->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="question">Question Text *</label>
            <textarea id="question" name="question" class="form-control" required>{{ old('question', $question->question) }}</textarea>
            @error('question')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer">Answer *</label>
            <input type="text" id="answer" name="answer" class="form-control" value="{{ old('answer', $question->answer) }}" required>
            @error('answer')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="points">Point Value *</label>
            <select id="points" name="points" class="form-control" required>
                <option value="200" {{ old('points', $question->points) == 200 ? 'selected' : '' }}>$200</option>
                <option value="400" {{ old('points', $question->points) == 400 ? 'selected' : '' }}>$400</option>
                <option value="600" {{ old('points', $question->points) == 600 ? 'selected' : '' }}>$600</option>
                <option value="800" {{ old('points', $question->points) == 800 ? 'selected' : '' }}>$800</option>
                <option value="1000" {{ old('points', $question->points) == 1000 ? 'selected' : '' }}>$1000</option>
                <option value="{{ $question->points }}" selected>Current: ${{ $question->points }}</option>
            </select>
            @error('points')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Question Image (Optional)</label>
            @if($question->image_path)
                <div style="margin-bottom: 10px;">
                    <img src="{{ Storage::url($question->image_path) }}" alt="Current image" style="max-width: 200px; border-radius: 5px;">
                    <p style="color: #7f8c8d; font-size: 14px;">Current question image</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('image').click()">
                <input type="file" id="image" name="image" accept="image/*" onchange="updateFileName(this, 'file-name')">
                <p id="file-name">📁 Click to upload new question image</p>
            </div>
            @error('image')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_image">Answer Image (Optional)</label>
            @if($question->answer_image_path)
                <div style="margin-bottom: 10px;">
                    <img src="{{ Storage::url($question->answer_image_path) }}" alt="Current answer image" style="max-width: 200px; border-radius: 5px;">
                    <p style="color: #7f8c8d; font-size: 14px;">Current answer image</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('answer_image').click()">
                <input type="file" id="answer_image" name="answer_image" accept="image/*" onchange="updateFileName(this, 'answer-file-name')">
                <p id="answer-file-name">📁 Click to upload new answer image</p>
            </div>
            @error('answer_image')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="video">Question Video (Optional)</label>
            @if($question->video_path)
                <div style="margin-bottom: 10px;">
                    <video controls style="max-width: 300px; border-radius: 5px;">
                        <source src="{{ Storage::url($question->video_path) }}" type="video/mp4">
                    </video>
                    <p style="color: #7f8c8d; font-size: 14px;">Current video</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('video').click()">
                <input type="file" id="video" name="video" accept="video/mp4,video/webm,video/ogg" onchange="updateFileName(this, 'video-file-name')">
                <p id="video-file-name">🎥 Click to upload new video (MP4, WebM, OGG)</p>
            </div>
            @error('video')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="audio">Question Audio (Optional)</label>
            @if($question->audio_path)
                <div style="margin-bottom: 10px;">
                    <audio controls style="max-width: 300px;">
                        <source src="{{ Storage::url($question->audio_path) }}" type="audio/mpeg">
                    </audio>
                    <p style="color: #7f8c8d; font-size: 14px;">Current audio</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('audio').click()">
                <input type="file" id="audio" name="audio" accept="audio/mpeg,audio/wav,audio/ogg" onchange="updateFileName(this, 'audio-file-name')">
                <p id="audio-file-name">🎵 Click to upload new audio (MP3, WAV, OGG)</p>
            </div>
            @error('audio')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_video">Answer Video (Optional)</label>
            @if($question->answer_video_path)
                <div style="margin-bottom: 10px;">
                    <video controls style="max-width: 300px; border-radius: 5px;">
                        <source src="{{ Storage::url($question->answer_video_path) }}" type="video/mp4">
                    </video>
                    <p style="color: #7f8c8d; font-size: 14px;">Current answer video</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('answer_video').click()">
                <input type="file" id="answer_video" name="answer_video" accept="video/mp4,video/webm,video/ogg" onchange="updateFileName(this, 'answer-video-file-name')">
                <p id="answer-video-file-name">🎥 Click to upload new answer video (MP4, WebM, OGG)</p>
            </div>
            @error('answer_video')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_audio">Answer Audio (Optional)</label>
            @if($question->answer_audio_path)
                <div style="margin-bottom: 10px;">
                    <audio controls style="max-width: 300px;">
                        <source src="{{ Storage::url($question->answer_audio_path) }}" type="audio/mpeg">
                    </audio>
                    <p style="color: #7f8c8d; font-size: 14px;">Current answer audio</p>
                </div>
            @endif
            <div class="file-upload" onclick="document.getElementById('answer_audio').click()">
                <input type="file" id="answer_audio" name="answer_audio" accept="audio/mpeg,audio/wav,audio/ogg" onchange="updateFileName(this, 'answer-audio-file-name')">
                <p id="answer-audio-file-name">🎵 Click to upload new answer audio (MP3, WAV, OGG)</p>
            </div>
            @error('answer_audio')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
const categoryQuestions = @json($categories->mapWithKeys(function($cat) {
    return [$cat->id => $cat->questions->pluck('points', 'id')->toArray()];
}));
const currentQuestionId = {{ $question->id }};

document.getElementById('questionForm').addEventListener('submit', function(e) {
    const categoryId = document.getElementById('category_id').value;
    const points = parseInt(document.getElementById('points').value);
    
    if (categoryId && points && categoryQuestions[categoryId]) {
        const existingQuestions = categoryQuestions[categoryId];
        const duplicateId = Object.keys(existingQuestions).find(id => 
            parseInt(id) !== currentQuestionId && existingQuestions[id] === points
        );
        
        if (duplicateId) {
            e.preventDefault();
            if (confirm(`A question with $${points} already exists in this category. Do you want to swap the point values? The existing question will be changed to a different value.`)) {
                // Add hidden field to indicate swap
                const swapInput = document.createElement('input');
                swapInput.type = 'hidden';
                swapInput.name = 'swap_question_id';
                swapInput.value = duplicateId;
                this.appendChild(swapInput);
                this.submit();
            }
        }
    }
});
</script>
@endsection

@section('scripts')
<script>
function updateFileName(input, targetId) {
    const fileName = input.files[0]?.name || 'No file selected';
    document.getElementById(targetId).textContent = '📁 ' + fileName;
}
</script>
@endsection
