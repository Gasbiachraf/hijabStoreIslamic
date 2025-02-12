<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::all();
        return view("Blogs.index", compact('blogs'));
    }

    public function edit(Blog $blog)
    {
        return view('Blogs.edit', compact('blog'));
    }



    public function create()
    {
        return view("Blogs.create");
    }

    public function store(Request $request)
    {
        request()->validate([
            "title" => "required",
            "description" => "required",
            "image" => "required|mimes:png,jpg|max:2048"
        ]);
        // dd($request);
        $image = $request->file("image");
        $filename = $image->hashName();
        $image->storeAs("blog_images/" . $filename);
        Blog::create([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $filename
        ]);

        return redirect()->route('blog.index');
    }

    public function update(Request $request, Blog $blog)
    {
        // dd($request->all());
        $request->validate([
            "title" => "required",
            "description" => "required",
            "image" => "required|mimes:png,jpg|max:2048"
        ]);

        if ($request->hasFile('image')) {

            if ($blog->image) {
                Storage::delete('public/blog_images/' . $blog->image);
            }

            $imagePath = $request->file('image')->store('blog_images', 'public');
            $blog->image = basename($imagePath);
        }


        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->save();

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully!');
    }


    public function destroy(Blog $blog)
    {
        Storage::disk("public")->delete('blog_images' . $blog->image);
        $blog->delete();
        return back();
    }


}
