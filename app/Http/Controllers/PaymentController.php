<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(Payment::with(['reservation','bank','invoice'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'bank_id' => 'required|exists:banks,id',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,confirmed,rejected',
            'payment_method' => 'required|string',
            'payment_reference' => 'required|string',
            'date' => 'required|date'
        ]);

        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'bank_id' => $request->bank_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'date' => $request->date,
        ]);

        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Payment::with(['reservation','bank','invoice'])->findOrFail($id);

        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => $request->status ?? $payment->status,
            'amount' => $request->amount ?? $payment->amount,
        ]);

        return response()->json($payment);
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}

