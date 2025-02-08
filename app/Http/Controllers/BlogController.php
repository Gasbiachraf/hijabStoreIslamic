<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //
    public function index(){
        $blogs = Blog::all();
        return view("Blogs.blogs" , compact('blogs'));
    }

    public function store(Request $request){
        request()->validate([
            "title"=>"required",
            "content"=>"required",
            "image" => "required|mimes:png,jpg|max:2048"
        ]);
        // dd($request);
        $image = $request->file("image");
        $filename =  $image->hashName();
        $image->storeAs("images/" . $filename);
        Blog::create([
            "title"=>$request->title,
            "description"=>$request->content,
            "image" => $filename
        ]);
        return back();
    }
    public function update(Request $request , Blog $blog){
        request()->validate([
            "title"=>"required",
            "content"=>"required",
        ]);
        if ($request->$request->hasFile('image')) {
            $image = $request->file("image");
            $filename =  $image->hashName();
            $image->storeAs("public/img/" . $filename);
            Storage::disk("public")->delete("img/" . $blog->image);
            $blog->update([
                "title"=>$request->title,
                "content"=>$request->content,
                "image" => $filename
            ]);
        }else {
            $blog->update([
                "title"=>$request->title,
                "content"=>$request->content,
                "image" => $blog->image
            ]);
        }
        return back();
    }
    public function destroy(Blog $blog)
    {
        Storage::disk("public")->delete("img/" . $blog->image);
        $blog->delete();
        return back();
    }

}
