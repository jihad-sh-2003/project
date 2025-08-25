<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class RatingController extends Controller
{
    
public function index(Request $request ,$property_id)
{
    $ratings=Rating::with('user')
    ->where('property_id',$property_id)
    ->get();

     return response()->json([
            'message' => 'Ratings retrieved successfully',
            'data' => $ratings,
        ], 200);


        
    }


    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'property_id' => $request->property_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return response()->json([
            'message' => 'Rating saved successfully',
            'data' => $rating,
        ], 201);
    }


    
    public function destroy(Request $request, $ratingId)
    {
        $deleted = Rating::where('id', $ratingId)
            ->where('user_id', $request->user()->id)
            ->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Rating deleted successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Rating not found',
        ], 404);
    }
    
}
