<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        try {
            $categories = Category::withCount('subcategories')->orderBy('name')->get();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('CategoryController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while loading categories. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        try {
            return view('categories.create');
        } catch (\Exception $e) {
            Log::error('CategoryController create error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while loading the create category page. Please try again.');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
            ]);

            Category::create($validated);

            flash()->success('Category created successfully!');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Log::error('CategoryController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            flash()->error('An error occurred while creating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        try {
            $category->load('subcategories');
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            Log::error('CategoryController show error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'category_id' => $category->id
            ]);

            flash()->error('An error occurred while loading the category. Please try again.');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        try {
            return view('categories.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error('CategoryController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'category_id' => $category->id
            ]);

            flash()->error('An error occurred while loading the edit category page. Please try again.');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);

            $category->update($validated);

            flash()->success('Category updated successfully!');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Log::error('CategoryController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'category_id' => $category->id,
                'request_data' => $request->all()
            ]);

            flash()->error('An error occurred while updating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has subcategories
            if ($category->subcategories()->count() > 0) {
                flash()->error('Cannot delete category that has subcategories. Please delete subcategories first.');
                return redirect()->route('categories.index');
            }

            $category->delete();

            flash()->success('Category deleted successfully!');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Log::error('CategoryController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'category_id' => $category->id
            ]);

            flash()->error('An error occurred while deleting the category. Please try again.');
            return redirect()->route('categories.index');
        }
    }
}
