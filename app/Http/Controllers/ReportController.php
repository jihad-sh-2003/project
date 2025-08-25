<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    
    public function index()
    {
        $reports = Report::with('user','property')
            ->get();

            $this->authorize('viewAny',$reports);
        return response()->json([
            'message' => 'Reports retrieved successfully',
            'data' => $reports,
        ], 200);
    }

    public function show(Request $request, $propertyId)
    {
         $reports = Report::with('user','property')
            ->where('property_id', $propertyId)
            ->get();

            $this->authorize('viewAny',$reports);
        return response()->json([
            'message' => 'Reports retrieved successfully',
            'data' => $reports,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reason' => 'required|string',
        ]);

        $report = Report::create([
            'user_id' => $request->user()->id,
            'property_id' => $request->property_id,
            'reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Report submitted successfully',
            'data' => $report,
        ], 201);
    }

    public function destroy(Request $request, $report_Id)
    {
          
        $report = Report::where('id', $report_Id)
            ->where('user_id', $request->user()->id)->get();
         
         $this->authorize('delete', $report);
         $report->delete();
        if ($report) {
            return response()->json([
                'message' => 'Report deleted successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Report not found',
        ], 404);
    }

}
