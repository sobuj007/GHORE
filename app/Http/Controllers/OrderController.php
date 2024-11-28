<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Myslot;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\OrderProducts;
use App\Models\ServiceProduct;
use App\Models\Appointmentslot;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch orders for the current authenticated agent
        // $orders = Orders::where('agent_id', Auth::id())->with('orderProducts.serviceProduct', 'payment')->get();
        $orders = Orders::where('agent_id', Auth::id())
        ->with(['orderProducts.serviceProduct2', 'payment'])
        ->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch service products for the current authenticated agent
$users = User::where('role', 'user')->get();
        $serviceProducts = ServiceProduct::all();
        $slots = Myslot::with('appointmentslots')->get(); // Load related appointmentslots
        $appointmentSlots = Appointmentslot::with('myslot')->get(); //
        return view('orders.create', compact('serviceProducts', 'appointmentSlots','slots','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required',
            'date' => 'required|date',
            'status' => 'required|in:pending,accepted,declined',
            'service_product_id' => 'required|exists:service_products,id',
            'product_quantity' => 'required|integer|min:1',
            'service_quantity' => 'required|integer|min:1',
            'product_price' => 'required|numeric',
            'service_price' => 'required|numeric',
            'selected_slot' => 'required|exists:appointmentslots,id',
        ]);
        // Extract validated data
$productQuantity = $validated['product_quantity'];
$serviceQuantity = $validated['service_quantity'];
$productPrice = $validated['product_price'];
$servicePrice = $validated['service_price'];

// Calculate total amounts
$totalProductAmount = $productQuantity * $productPrice;
$totalServiceAmount = $serviceQuantity * $servicePrice;

// Calculate grand total if needed
$grandTotal = $totalProductAmount + $totalServiceAmount;

        $order = Orders::create([
            'user_id' =>Auth::id(),
            'agent_id' =>  $validated['agent_id'],
            'total_amount' =>  $grandTotal,
            'order_date' => $validated['date'],
            'status' => $validated['status'],
        ]);

        OrderProducts::create([
            'order_id' => $order->id,
            'service_product_id' => $validated['service_product_id'],
            'product_quantity' => $validated['product_quantity'],
            'service_quantity' => $validated['service_quantity'],
            'product_price' => $validated['product_price'],
            'service_price' => $validated['service_price'],
            'selected_slot' => $validated['selected_slot'],
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $order)
    {
        // Ensure the current agent can only edit their own orders
        $this->authorize('update', $order);

        $serviceProducts = ServiceProduct::where('agent_id', Auth::id())->get();
        $appointmentSlots = Appointmentslot::all();
        $orderProducts = $order->orderProducts;

        return view('orders.edit', compact('order', 'serviceProducts', 'appointmentSlots', 'orderProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:pending,accepted,declined',
            'service_product_id' => 'required|exists:service_products,id',
            'product_quantity' => 'required|integer|min:1',
            'service_quantity' => 'required|integer|min:1',
            'product_price' => 'required|numeric',
            'service_price' => 'required|numeric',
            'selected_slot' => 'required|exists:appointmentslots,id',
        ]);

        $order->update([
            'date' => $validated['date'],
            'status' => $validated['status'],
        ]);

        $orderProduct = $order->orderProducts()->first();
        $orderProduct->update([
            'service_product_id' => $validated['service_product_id'],
            'product_quantity' => $validated['product_quantity'],
            'service_quantity' => $validated['service_quantity'],
            'product_price' => $validated['product_price'],
            'service_price' => $validated['service_price'],
            'selected_slot' => $validated['selected_slot'],
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }
}
