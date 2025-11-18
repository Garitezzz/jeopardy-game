{{--
    Create Category View
    
    Form for creating a new Jeopardy category.
--}}
{{-- Extend the admin layout template --}}
@extends('layouts.admin')

{{-- Set the page title that appears in the browser tab --}}
@section('title', 'Create Category')

{{-- Main content section --}}
@section('content')
{{-- Page header with title and description --}}
<div class="page-header">
    <h1>Create New Category</h1>
    <p>Add a new category to your Jeopardy game</p>
</div>

{{-- Card container for the form --}}
<div class="card">
    {{-- Form submits to the categories store route using POST method --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        {{-- CSRF token for Laravel security --}}
        @csrf
        
        {{-- Category name input field (required) --}}
        <div class="form-group">
            <label for="name">Category Name *</label>
            {{-- Input retains old value if validation fails --}}
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            {{-- Display validation error for name field if exists --}}
            @error('name')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- Category description textarea (optional) --}}
        <div class="form-group">
            <label for="description">Description</label>
            {{-- Textarea retains old value if validation fails --}}
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            {{-- Display validation error for description field if exists --}}
            @error('description')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- Final Jeopardy checkbox option --}}
        <div class="form-group">
            <label>
                {{-- Checkbox remains checked if it was previously checked --}}
                <input type="checkbox" name="is_final_jeopardy" value="1" {{ old('is_final_jeopardy') ? 'checked' : '' }}>
                <span style="margin-left: 8px; font-weight: normal;">Final Jeopardy / Overtime Category</span>
            </label>
            {{-- Helper text explaining the checkbox purpose --}}
            <small style="display: block; color: #7f8c8d; margin-top: 5px;">Check this for Final Jeopardy or overtime questions (typically has only one question)</small>
        </div>
        
        {{-- Action buttons for form submission and cancellation --}}
        <div class="action-buttons">
            {{-- Submit button to create the category --}}
            <button type="submit" class="btn btn-primary">Create Category</button>
            {{-- Cancel button returns to categories list --}}
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
