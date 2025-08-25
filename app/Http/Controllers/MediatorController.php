<?php

namespace App\Http\Controllers;

use App\Models\Mediator;
use Illuminate\Http\Request;

class MediatorController extends Controller
{
    public function index()
    {
        return response()->json(Mediator::all());
    }
// asfdasdsd
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string',
            'location' => 'nullable|string'
        ]);

        $mediator = Mediator::create([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'location' => $request->location,
        ]);

        return response()->json($mediator, 201);
    }

    public function show($id)
    {
        $mediator = Mediator::with('appointments')->findOrFail($id);
        return response()->json($mediator);
    }

    public function update(Request $request, $id)
    {
        $mediator = Mediator::findOrFail($id);

        $mediator->update([
            'name' => $request->name ?? $mediator->name,
            'contact_info' => $request->contact_info ?? $mediator->contact_info,
            'location' => $request->location ?? $mediator->location,
        ]);

        return response()->json($mediator);
    }

    public function destroy($id)
    {
        Mediator::findOrFail($id)->delete();
        return response()->json(['message' => 'Mediator deleted successfully']);
    }
}
