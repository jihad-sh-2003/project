<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json(['message' => 'wallet is not found'], 404);
        }

        return response()->json([
            'balance' => $wallet->balance,
            'transactions' => $wallet->transactions
        ]);
    }

    // إضافة رصيد
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'reference_number' => 'required|string'
        ]);

        $user = $request->user();

        $wallet = $user->wallet ?? $user->wallet()->create([
            'balance' => 0,
            'last_updated' => now(),
        ]);

        $transaction = $wallet->transactions()->create([
            'amount' => $request->amount,
            'method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'approved' => true,
        ]);

        $wallet->balance += $transaction->amount;
        $wallet->last_updated = now();
        $wallet->save();

        return response()->json([
            'message' => 'added successfuly',
            'balance' => $wallet->balance
        ]);
    }

    // خصم رصيد
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'reference_number' => 'required|string'
        ]);

        $user = $request->user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json(['message' => 'user has not wallet'], 404);
        }

        if ($wallet->balance < $request->amount && $request->amount>0 ) {
            return response()->json(['message' => 'insufficient balance ','balance'=>$wallet->balance], 400);
        }

        $transaction = $wallet->transactions()->create([
            'amount' => -$request->amount,
            'method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'approved' => true,
        ]);

        $wallet->balance += $transaction->amount;
        $wallet->last_updated = now();
        $wallet->save();

        return response()->json([
            'message' => 'deducation successfully',
            'balance' => $wallet->balance
        ]);
    }
}
