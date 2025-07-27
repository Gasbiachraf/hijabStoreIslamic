<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index()
    {
        try {
            $blogs = Blog::all();
            return view("Blogs.index", compact('blogs'));
        } catch (\Exception $e) {
            Log::error('BlogController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading blogs. Please try again.');
        }
    }

    public function edit(Blog $blog)
    {
        try {
            return view('Blogs.edit', compact('blog'));
        } catch (\Exception $e) {
            Log::error('BlogController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'blog_id' => $blog->id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the blog. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view("Blogs.create");
        } catch (\Exception $e) {
            Log::error('BlogController create error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the create blog page. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            request()->validate([
                "title" => "required",
                "description" => "required",
                "image" => "required|mimes:png,jpg|max:2048"
            ]);
            // dd($request);
            $image = $request->file("image");
            $filename = $image->hashName();
            $image->storeAs("images/" . $filename);
            Blog::create([
                "title" => $request->title,
                "description" => $request->description,
                "image" => $filename
            ]);

            return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
        } catch (\Exception $e) {
            Log::error('BlogController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while creating the blog. Please try again.');
        }
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            // dd($request->all());
            $request->validate([
                "title" => "required",
                "description" => "required",
                "image" => "mimes:png,jpg"
            ]);
            // dd($request);

            if ($request->hasFile('image')) {

                if ($blog->image) {
                    Storage::delete('public/images/' . $blog->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $blog->image = basename($imagePath);
            }
            $blog->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

            return redirect()->route('blog.index')->with('success', 'Blog updated successfully!');
        } catch (\Exception $e) {
            Log::error('BlogController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'blog_id' => $blog->id
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating the blog. Please try again.');
        }
    }


    public function destroy(Blog $blog)
    {
        try {
            Storage::disk("public")->delete('images' . $blog->image);
            $blog->delete();
            return back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            Log::error('BlogController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'blog_id' => $blog->id
            ]);

            return back()->with('error', 'An error occurred while deleting the blog. Please try again.');
        }
    }
}
