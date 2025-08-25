<?php

namespace App\Http\Controllers;

use App\Models\MediatorAppointment;
use Illuminate\Http\Request;

class MediatorAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $appointments = MediatorAppointment::with(['mediator','property'])
            ->where('user_id', $userId)
            ->get();

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mediator_id' => 'required|exists:mediators,id',
            'property_id' => 'required|exists:properties,id',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $appointment = MediatorAppointment::create([
            'mediator_id' => $request->mediator_id,
            'user_id' => $request->user()->id,
            'property_id' => $request->property_id,
            'status' => 'pending',
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return response()->json($appointment, 201);
    }

    public function show($id)
    {
        $appointment = MediatorAppointment::with(['mediator','property','user'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = MediatorAppointment::findOrFail($id);

        $appointment->update([
            'status' => $request->status ?? $appointment->status,
            'date' => $request->date ?? $appointment->date,
            'time' => $request->time ?? $appointment->time,
        ]);

        return response()->json($appointment);
    }

    public function destroy($id)
    {
        MediatorAppointment::findOrFail($id)->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
