{{--
    Edit Category View
    
    Form for editing an existing category's name and description.
--}}
{{-- Extend the admin layout template --}}
@extends('layouts.admin')

{{-- Set the page title --}}
@section('title', 'Edit Category')

{{-- Main content section --}}
@section('content')
{{-- Page header --}}
<div class="page-header">
    <h1>Edit Category</h1>
    <p>Update category information</p>
</div>

{{-- Card container for the edit form --}}
<div class="card">
    {{-- Form submits to update route using PUT method --}}
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        {{-- CSRF token for security --}}
        @csrf
        {{-- Method spoofing for PUT request (HTML forms only support GET/POST) --}}
        @method('PUT')
        
        {{-- Category name input field --}}
        <div class="form-group">
            <label for="name">Category Name *</label>
            {{-- Input shows existing category name, or old input if validation failed --}}
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            {{-- Display validation error if exists --}}
            @error('name')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- Category description textarea --}}
        <div class="form-group">
            <label for="description">Description</label>
            {{-- Textarea shows existing description, or old input if validation failed --}}
            <textarea id="description" name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
            {{-- Display validation error if exists --}}
            @error('description')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- Final Jeopardy checkbox --}}
        <div class="form-group">
            <label>
                {{-- Checkbox is checked if category is already final jeopardy or if old input was checked --}}
                <input type="checkbox" name="is_final_jeopardy" value="1" {{ old('is_final_jeopardy', $category->is_final_jeopardy) ? 'checked' : '' }}>
                <span style="margin-left: 8px; font-weight: normal;">Final Jeopardy / Overtime Category</span>
            </label>
            {{-- Helper text --}}
            <small style="display: block; color: #7f8c8d; margin-top: 5px;">Check this for Final Jeopardy or overtime questions (typically has only one question)</small>
        </div>
        
        {{-- Action buttons --}}
        <div class="action-buttons">
            {{-- Submit button to update the category --}}
            <button type="submit" class="btn btn-primary">Update Category</button>
            {{-- Cancel button returns to categories list --}}
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
