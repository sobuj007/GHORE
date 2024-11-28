<?php

namespace App\Http\Controllers\Order;

use App\Models\Payment;
use App\Models\OrdersNew;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

public function storepayment(Request $request)
{
    // Validate the request
    $request->validate([
        'order_id' => 'required|exists:orders_news,id',
        'amount' => 'required|numeric|min:0',
        'status' => 'required',
        'address' => 'required',
        'note' => 'nullable',
        'mobile' => 'required',
      

    ]);

    // Create the payment
    $payment = Payment::create([
        'order_id' => $request->order_id,
        'amount' => $request->amount,
        'status' => $request->status,
        'trans_type' => $request->trans_type,
        'address' => $request->address,
        'note' => $request->note,
        'mobile' => $request->mobile,

        // Optionally, you can add more fields like 'transaction_id', 'status', etc.
    ]);

    // Return the response to the client
    return response()->json([
        'message' => 'Payment created successfully!',
        'payment' => $payment
    ], 201);
}
    /**
     * Display the specified payment.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showpayment($id)
    {
        // Find the payment
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'payment' => $payment
        ]);
    }

    /**
     * Get all payments for a specific order.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByOrderIdpayment($orderId)
    {
        // Validate the order_id
        $orderExists = OrdersNew::find($orderId);
        if (!$orderExists) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        // Retrieve payments for the specified order
        $payments = Payment::where('order_id', $orderId)->get();

        return response()->json([
            'payments' => $payments
        ]);
    }

}
