@extends('layouts.admin')

@section('title', 'Create Question')

@section('content')
<div class="page-header">
    <h1>Create New Question</h1>
    <p>Add a new question to your Jeopardy game</p>
</div>

<div class="card">
    <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
            <textarea id="question" name="question" class="form-control" required>{{ old('question') }}</textarea>
            @error('question')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer">Answer *</label>
            <input type="text" id="answer" name="answer" class="form-control" value="{{ old('answer') }}" required>
            @error('answer')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="points">Point Value *</label>
            <select id="points" name="points" class="form-control" required>
                <option value="">Select points</option>
                <option value="200" {{ old('points') == 200 ? 'selected' : '' }}>$200</option>
                <option value="400" {{ old('points') == 400 ? 'selected' : '' }}>$400</option>
                <option value="600" {{ old('points') == 600 ? 'selected' : '' }}>$600</option>
                <option value="800" {{ old('points') == 800 ? 'selected' : '' }}>$800</option>
                <option value="1000" {{ old('points') == 1000 ? 'selected' : '' }}>$1000</option>
            </select>
            <small style="color: #7f8c8d;">Or enter custom value:</small>
            <input type="number" name="custom_points" class="form-control" placeholder="Custom point value" style="margin-top: 5px;" min="100">
            @error('points')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Question Image (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('image').click()">
                <input type="file" id="image" name="image" accept="image/*" onchange="updateFileName(this, 'file-name')">
                <p id="file-name">📁 Click to upload image (background, silhouette, item, outfit, etc.)</p>
            </div>
            @error('image')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_image">Answer Image (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('answer_image').click()">
                <input type="file" id="answer_image" name="answer_image" accept="image/*" onchange="updateFileName(this, 'answer-file-name')">
                <p id="answer-file-name">📁 Click to upload answer reveal image</p>
            </div>
            @error('answer_image')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="video">Question Video (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('video').click()">
                <input type="file" id="video" name="video" accept="video/mp4,video/webm,video/ogg" onchange="updateFileName(this, 'video-file-name')">
                <p id="video-file-name">🎥 Click to upload video (MP4, WebM, OGG)</p>
            </div>
            @error('video')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="audio">Question Audio (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('audio').click()">
                <input type="file" id="audio" name="audio" accept="audio/mpeg,audio/wav,audio/ogg" onchange="updateFileName(this, 'audio-file-name')">
                <p id="audio-file-name">🎵 Click to upload audio (MP3, WAV, OGG)</p>
            </div>
            @error('audio')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_video">Answer Video (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('answer_video').click()">
                <input type="file" id="answer_video" name="answer_video" accept="video/mp4,video/webm,video/ogg" onchange="updateFileName(this, 'answer-video-file-name')">
                <p id="answer-video-file-name">🎥 Click to upload answer reveal video (MP4, WebM, OGG)</p>
            </div>
            @error('answer_video')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="answer_audio">Answer Audio (Optional)</label>
            <div class="file-upload" onclick="document.getElementById('answer_audio').click()">
                <input type="file" id="answer_audio" name="answer_audio" accept="audio/mpeg,audio/wav,audio/ogg" onchange="updateFileName(this, 'answer-audio-file-name')">
                <p id="answer-audio-file-name">🎵 Click to upload answer reveal audio (MP3, WAV, OGG)</p>
            </div>
            @error('answer_audio')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">Create Question</button>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
const categoryQuestions = @json($categories->mapWithKeys(function($cat) {
    return [$cat->id => $cat->questions->pluck('points', 'id')->toArray()];
}));

document.getElementById('questionForm').addEventListener('submit', function(e) {
    const categoryId = document.getElementById('category_id').value;
    const points = parseInt(document.getElementById('points').value);
    
    if (categoryId && points && categoryQuestions[categoryId]) {
        const existingQuestions = categoryQuestions[categoryId];
        const duplicateId = Object.keys(existingQuestions).find(id => existingQuestions[id] === points);
        
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

document.querySelector('input[name="custom_points"]').addEventListener('input', function(e) {
    if (this.value) {
        document.getElementById('points').value = '';
        document.getElementById('points').removeAttribute('required');
    } else {
        document.getElementById('points').setAttribute('required', 'required');
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    const customPoints = document.querySelector('input[name="custom_points"]').value;
    if (customPoints) {
        document.getElementById('points').value = customPoints;
    }
});
</script>
@endsection
