<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return response()->json(Reservation::with(['user','property'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'status' => 'required|in:pending,approved,rejected',
            'deposit_amount' => 'required|numeric|min:0'
        ]);

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'property_id' => $request->property_id,
            'status' => $request->status,
            'deposit_amount' => $request->deposit_amount,
        ]);

        return response()->json($reservation, 201);
    }

    public function show($id)
    {
        $reservation = Reservation::with(['user','property','payments','ownershipDocuments'])
            ->findOrFail($id);

        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status' => $request->status ?? $reservation->status,
            'deposit_amount' => $request->deposit_amount ?? $reservation->deposit_amount,
        ]);

        return response()->json($reservation);
    }

    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}


