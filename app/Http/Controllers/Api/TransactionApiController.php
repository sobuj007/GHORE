<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Payment::all();
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,completed,failed',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction = Payment::create($validator->validated());

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $transaction)
    {
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $transaction)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,completed,failed',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $transaction->update($validator->validated());

        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $transaction)
    {
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }

// Other CRUD methods...

    /**
     * Get transactions by order_id.
     *
     * @param  int  $order_id
     * @return \Illuminate\Http\Response
     */
    public function getTransactionsByOrderId($order_id)
    {
        $transactions = Payment::where('order_id', $order_id)->get();

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'No transactions found for this order ID'], 404);
        }

        return response()->json($transactions, 200);
    }

}
