@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="page-header">
    <h1>Create New Category</h1>
    <p>Add a new category to your Jeopardy game</p>
</div>

<div class="card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Category Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_final_jeopardy" value="1" {{ old('is_final_jeopardy') ? 'checked' : '' }}>
                <span style="margin-left: 8px; font-weight: normal;">Final Jeopardy / Overtime Category</span>
            </label>
            <small style="display: block; color: #7f8c8d; margin-top: 5px;">Check this for Final Jeopardy or overtime questions (typically has only one question)</small>
        </div>
        
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
