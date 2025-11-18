{{--
    Admin Settings View
    
    Game configuration page for managing title, subtitle, logo, and rules.
--}}
@extends('layouts.admin')

@section('title', 'Game Settings')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Game Settings</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h2>Main Title Screen Settings</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="main_title">Main Title</label>
                    <input type="text" id="main_title" name="main_title" value="{{ old('main_title', $settings['main_title']) }}" required>
                    @error('main_title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="main_subtitle">Subtitle (Optional)</label>
                    <input type="text" id="main_subtitle" name="main_subtitle" value="{{ old('main_subtitle', $settings['main_subtitle']) }}">
                    @error('main_subtitle')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="main_logo">Logo Image (Optional)</label>
                    @if($settings['main_logo'])
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $settings['main_logo']) }}" alt="Current Logo" style="max-width: 300px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        </div>
                    @endif
                    <input type="file" id="main_logo" name="main_logo" accept="image/*">
                    <small style="display: block; margin-top: 5px; color: #666;">Recommended size: 600x200px or similar aspect ratio</small>
                    @error('main_logo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Rules Page Content</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="rules_content">Rules Content (HTML allowed)</label>
                    <textarea id="rules_content" name="rules_content" rows="20" required>{{ old('rules_content', $settings['rules_content']) }}</textarea>
                    <small style="display: block; margin-top: 5px; color: #666;">
                        You can use HTML tags like &lt;h2&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, etc.
                    </small>
                    @error('rules_content')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 16px;">Save Settings</button>
        </div>
    </form>
</div>

<style>
    .card {
        margin-bottom: 30px;
    }
    
    .card-header h2 {
        font-size: 20px;
        margin: 0;
    }
    
    textarea {
        font-family: 'Courier New', monospace;
        font-size: 14px;
    }
</style>
@endsection
