<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a list of all categories with question counts
     */
    public function index()
    {
        $categories = Category::withCount('questions')->orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form to create a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category in the database
     * Automatically assigns the next order number
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = Category::max('order') ?? 0;
        
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show the form to edit an existing category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the database
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'description']));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from the database
     * Note: This will also delete all associated questions
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}

