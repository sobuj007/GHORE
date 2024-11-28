<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\OrderProducts;
use App\Models\ServiceProduct;
use App\Models\Appointmentslot;

class DashboardController extends Controller
{
    //
    public function index(){
        $products =ServiceProduct::all();
        return view('users.dashboard',compact('products'));
    }
    public function create()
    {
        $serviceProducts = ServiceProduct::all();
        $slots = Appointmentslot::all();
        return view('users.create', compact('serviceProducts', 'slots'));
    }

    public function store(Request $request)
    {
        $order = Orders::create([
            'user_id' => auth()->id(),
            'agent_id' => $request->agent_id,
            'status' => 'pending', // or other status
            'date' => $request->date,
        ]);

        foreach ($request->products as $product) {
            OrderProducts::create([
                'order_id' => $order->id,
                'service_product_id' => $product['service_product_id'],
                'product_quantity' => $product['product_quantity'],
                'product_price' => $product['product_price'],
                'service_quantity' => $product['service_quantity'],
                'service_price' => $product['service_price'],
                'selected_slot' => $product['selected_slot'],
            ]);
        }

        return redirect()->with('success', 'Order created successfully!');
    }

}
