<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $img = $request->file('images');
        $variant = Variant::find($request->variant_id);
        $imageName = time() . '_' . $img->getClientOriginalName();
        $image = $variant->images()->create([
            'path' => $imageName
        ]);
        $img->storeAs('images', $imageName, 'public');
        return response()->json([
        'id' => $image->id,
        'path' => $imageName, 
    ]);
    }
    public function destroy($id)
    {
        $image = Image::find($id);
        Storage::disk('public')->delete('images/' . $image->path);
        $image->delete();
        return response()->json('image deleted successfully');
    }
}
