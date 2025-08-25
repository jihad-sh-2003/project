<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::with('payment')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:issued,cancelled',
            'notes' => 'nullable|string'
        ]);

        $invoice = Invoice::create([
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json($invoice, 201);
    }

    public function show($id)
    {
        $invoice = Invoice::with('payment')->findOrFail($id);

        return response()->json($invoice);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'status' => $request->status ?? $invoice->status,
            'notes' => $request->notes ?? $invoice->notes,
        ]);

        return response()->json($invoice);
    }

    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}

