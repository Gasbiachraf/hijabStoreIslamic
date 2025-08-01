<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     */
    public function index()
    {
        try {
            $subcategories = Subcategory::with('category')->orderBy('name')->get();
            return view('subcategories.index', compact('subcategories'));
        } catch (\Exception $e) {
            Log::error('SubcategoryController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while loading subcategories. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        try {
            $categories = Category::orderBy('name')->get();
            return view('subcategories.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('SubcategoryController create error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while loading the create subcategory page. Please try again.');
            return redirect()->route('subcategories.index');
        }
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Check if subcategory name is unique within the category
            $exists = Subcategory::where('name', $validated['name'])
                                ->where('category_id', $validated['category_id'])
                                ->exists();

            if ($exists) {
                flash()->error('A subcategory with this name already exists in the selected category.');
                return redirect()->back()->withInput();
            }

            Subcategory::create($validated);

            flash()->success('Subcategory created successfully!');
            return redirect()->route('subcategories.index');
        } catch (\Exception $e) {
            Log::error('SubcategoryController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            flash()->error('An error occurred while creating the subcategory. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified subcategory.
     */
    public function show(Subcategory $subcategory)
    {
        try {
            $subcategory->load(['category', 'products']);
            return view('subcategories.show', compact('subcategory'));
        } catch (\Exception $e) {
            Log::error('SubcategoryController show error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'subcategory_id' => $subcategory->id
            ]);

            flash()->error('An error occurred while loading the subcategory. Please try again.');
            return redirect()->route('subcategories.index');
        }
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit(Subcategory $subcategory)
    {
        try {
            $categories = Category::orderBy('name')->get();
            return view('subcategories.edit', compact('subcategory', 'categories'));
        } catch (\Exception $e) {
            Log::error('SubcategoryController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'subcategory_id' => $subcategory->id
            ]);

            flash()->error('An error occurred while loading the edit subcategory page. Please try again.');
            return redirect()->route('subcategories.index');
        }
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Check if subcategory name is unique within the category (excluding current subcategory)
            $exists = Subcategory::where('name', $validated['name'])
                                ->where('category_id', $validated['category_id'])
                                ->where('id', '!=', $subcategory->id)
                                ->exists();

            if ($exists) {
                flash()->error('A subcategory with this name already exists in the selected category.');
                return redirect()->back()->withInput();
            }

            $subcategory->update($validated);

            flash()->success('Subcategory updated successfully!');
            return redirect()->route('subcategories.index');
        } catch (\Exception $e) {
            Log::error('SubcategoryController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'subcategory_id' => $subcategory->id,
                'request_data' => $request->all()
            ]);

            flash()->error('An error occurred while updating the subcategory. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        try {
            // Check if subcategory has products
            if ($subcategory->products()->count() > 0) {
                flash()->error('Cannot delete subcategory that has products. Please delete or reassign products first.');
                return redirect()->route('subcategories.index');
            }

            $subcategory->delete();

            flash()->success('Subcategory deleted successfully!');
            return redirect()->route('subcategories.index');
        } catch (\Exception $e) {
            Log::error('SubcategoryController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'subcategory_id' => $subcategory->id
            ]);

            flash()->error('An error occurred while deleting the subcategory. Please try again.');
            return redirect()->route('subcategories.index');
        }
    }
}
