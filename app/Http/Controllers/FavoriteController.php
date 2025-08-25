<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
 

    public function index(Request $request)
    {
        $properties=Favorite::with('property')->
        where('user_id',$request->user()->id)
        ->get();
        return response()->json([
            'message'=>'properties retrieved successfully',
            'data'=>$properties,
        ],200);

    }

    public function store(Request $request )
    {
          $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);
        
        Favorite::firstOrCreate([
            'user_id'=>$request->user()->id,
            'property_id'=>$request->property_id,

        ]);

            return response()->json([
            'message'=>' Added to favorites',
        ],201);

    }

public function destroy(Request $request, $property_id)
{
    $deleted = Favorite::where('user_id', $request->user()->id)
        ->where('property_id', $property_id)
        ->delete();

    if ($deleted) {
        return response()->json([
            'message' => 'Deleted from favorites',
        ], 200);
    }

    return response()->json([
        'message' => 'Favorite not found',
    ], 404);
}


}
