<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends Controller
{
   
    
    public function addImage(Request $request, Property $property)
{
    $this->authorize('update', $property);

    $request->validate([
        'image' => 'required|image|max:2048',
    ]);

    $path = $request->file('image')->store('property_images');

    $property->images()->create([
        'image_path' => $path,
    ]);

    return response()->json(['message' => 'Image uploaded successfully'], 201);
}


public function deleteImage(Property $property, $imageId)
{
    $this->authorize('update', $property);
    $image = PropertyImage::findOrFail($imageId);
     $image->delete();

    return response()->json(['message' => 'Image deleted successfully']);
}


 public function getImageUrl($imageId)
    {
         $image = PropertyImage::findOrFail($imageId);

    // نتأكد إذا الملف موجود
    if (!Storage::disk('public')->exists($image->image_path)) {
        return response()->json([
            'error' => 'Image file not found'
        ], 404);
    }

    // نرجع رابط مباشر للصورة
    return response()->json([
        'url' => asset('storage/' . $image->image_path)
    ]);
    }

}
