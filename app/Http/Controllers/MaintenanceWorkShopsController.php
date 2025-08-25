<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceWorkShops;
use Illuminate\Http\Request;

class MaintenanceWorkShopsController extends Controller
{
    public function index()
    {
            $WorkShops=MaintenanceWorkShops::get();
    return response()->
        json(['data'=>$WorkShops ],200);
        
    }




    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'work_type' => 'required',
            'phone_number' => 'required|string',
                        'location' => 'nullable|text',

        ]);

        $WorkShops = MaintenanceWorkShops::create(
            [
                'name' => $request->name,
                'work_type' => $request->work_type,
           
                'phone_number' => $request->phone_number,
                'location' => $request->location,
            ]
        );

        return response()->json([
            'message' => 'created successfully',
            'data' => $WorkShops,
        ], 201);
    }


    
    public function destroy(Request $request, $WorkShopsId)
    {
        $deleted = MaintenanceWorkShops::where('id', $WorkShopsId)
            ->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'WorkShops deleted successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'WorkShops not found',
        ], 404);
    }
    


    }


