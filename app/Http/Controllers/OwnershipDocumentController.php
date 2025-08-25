<?php

namespace App\Http\Controllers;

use App\Models\OwnershipDocument;
use Illuminate\Http\Request;

class OwnershipDocumentController extends Controller
{
    public function index()
    {
        return response()->json(OwnershipDocument::with('reservation')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'document_type' => 'required|string',
            'document_url' => 'required|string',
            'upload_at' => 'nullable|date'
        ]);

        $doc = OwnershipDocument::create([
            'reservation_id' => $request->reservation_id,
            'document_type' => $request->document_type,
            'document_url' => $request->document_url,
            'upload_at' => $request->upload_at,
        ]);

        return response()->json($doc, 201);
    }

    public function show($id)
    {
        $doc = OwnershipDocument::with('reservation')->findOrFail($id);

        return response()->json($doc);
    }

    public function update(Request $request, $id)
    {
        $doc = OwnershipDocument::findOrFail($id);

        $doc->update([
            'document_type' => $request->document_type ?? $doc->document_type,
            'document_url' => $request->document_url ?? $doc->document_url,
            'upload_at' => $request->upload_at ?? $doc->upload_at,
        ]);

        return response()->json($doc);
    }

    public function destroy($id)
    {
        OwnershipDocument::findOrFail($id)->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}

