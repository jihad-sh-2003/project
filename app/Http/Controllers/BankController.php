<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
   
    public function index()
    {
        $Banks=Bank::get();
        return response()->json(['data'=>$Banks], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
        ]);

        $bank = Bank::create($request->only(['name','account_number']));

        return response()->json(['data'=>$bank], 201);
    }

    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        return response()->json(['data'=>$bank], 200);
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $bank->update($request->only(['name','account_number']));

        return response()->json(['data'=>$bank], 200);
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
