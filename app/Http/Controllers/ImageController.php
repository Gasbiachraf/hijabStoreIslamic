<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'variant_id' => 'required|exists:variants,id',
                'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $img = $request->file('images');
            $variant = Variant::find($request->variant_id);
            if (!$variant) {
                return response()->json(['error' => 'Variant not found'], 404);
            }

            $imageName = time() . '_' . $img->getClientOriginalName();
            $image = $variant->images()->create([
                'path' => $imageName
            ]);
            $img->storeAs('images', $imageName, 'public');
            return response()->json([
                'id' => $image->id,
                'path' => $imageName,
            ]);
        } catch (\Exception $e) {
            Log::error('ImageController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'An error occurred while uploading the image'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $image = Image::find($id);
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            Storage::disk('public')->delete('images/' . $image->path);
            $image->delete();
            return response()->json(['message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            Log::error('ImageController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'image_id' => $id
            ]);

            return response()->json(['error' => 'An error occurred while deleting the image'], 500);
        }
    }
}
