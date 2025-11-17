<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $categories = Category::with('questions')->withCount('questions')->orderBy('order')->get();
        $totalQuestions = Question::count();
        
        return view('admin.dashboard', compact('categories', 'totalQuestions'));
    }

    public function settings()
    {
        $settings = [
            'main_title' => Settings::get('main_title', 'JEOPARDY!'),
            'main_subtitle' => Settings::get('main_subtitle'),
            'main_logo' => Settings::get('main_logo'),
            'rules_content' => Settings::get('rules_content'),
        ];
        
        return view('admin.settings', compact('settings'));
    }

    public function export()
    {
        $data = [
            'categories' => Category::with('questions')->orderBy('order')->get(),
            'exported_at' => now()->toISOString(),
        ];

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="jeopardy-data-' . date('Y-m-d') . '.json"'
        ], JSON_PRETTY_PRINT);
    }

    public function import(Request $request)
    {
        $request->validate([
            'json_file' => 'nullable|file|mimes:json,txt',
            'json_code' => 'nullable|string',
        ]);

        // Get JSON content from either file or textarea
        if ($request->hasFile('json_file')) {
            $content = file_get_contents($request->file('json_file')->getRealPath());
        } elseif ($request->filled('json_code')) {
            $content = $request->json_code;
        } else {
            return back()->with('error', 'Please provide either a JSON file or paste JSON code.');
        }

        $data = json_decode($content, true);

        if (!isset($data['categories'])) {
            return back()->with('error', 'Invalid JSON format. Make sure it has a "categories" array.');
        }

        // Clear existing data
        Question::truncate();
        Category::truncate();

        // Import categories and questions
        foreach ($data['categories'] as $categoryData) {
            $questions = $categoryData['questions'] ?? [];
            unset($categoryData['questions']);
            
            $category = Category::create($categoryData);

            foreach ($questions as $questionData) {
                $category->questions()->create($questionData);
            }
        }

        return back()->with('success', 'Data imported successfully!');
    }
    
    public function updateSettings(Request $request)
    {
        $request->validate([
            'main_title' => 'required|string|max:255',
            'main_subtitle' => 'nullable|string|max:500',
            'rules_content' => 'required|string',
            'main_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        Settings::set('main_title', $request->main_title);
        Settings::set('main_subtitle', $request->main_subtitle);
        Settings::set('rules_content', $request->rules_content);
        
        if ($request->hasFile('main_logo')) {
            // Delete old logo if exists
            $oldLogo = Settings::get('main_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $path = $request->file('main_logo')->store('logos', 'public');
            Settings::set('main_logo', $path);
        }
        
        return back()->with('success', 'Settings updated successfully!');
    }
}
