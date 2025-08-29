<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
     protected $table = 'documents_verification_table';


     
    public function addDocument(Request $request, $property_id)
{
    $property=Property::findOrFail($property_id);

    $request->validate([
        'document_type'=>'required',
        'file_path'=>'required|image|max:2048'
        ]);

    $file_path = $request->file('file_path')->store('property_documents');

    $property->Documents()->create([
           'document_type'=>$request->document_type,
        'file_path' => $file_path,
    ]);

    return response()->json(['message' => 'document uploaded successfully'], 201);
}


public function deleteDocument( $document_id)
{
    $document = Document::findOrFail($document_id);
     $document->delete();

    return response()->json(['message' => 'document deleted successfully']);
}


 public function getDocument($document_id)
    {
         $document = Document::findOrFail($document_id);

    // نتأكد إذا الملف موجود
    if (!Storage::disk('')->exists($document->file_path)) {
        return response()->json([
            'error' => 'Image file not found'
        ], 404);
    }

    // نرجع رابط مباشر للصورة
    return response()->json([
        'document type'=>$document->document_type,
        'url' => asset('storage/' . $document->file_path)
        
    ]);
    }



}
