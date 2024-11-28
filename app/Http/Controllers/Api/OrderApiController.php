<?php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Orders;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\OrderProducts;
use App\Models\ServiceProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::where('agent_id', Auth::id())
            ->with(['orderProducts.serviceProduct', 'payment'])
            ->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required',
            'date' => 'required|array',
            'date.*' => 'required', 
            'status' => 'required|in:pending,accepted,declined',
            'service_product_ids' => 'required|array',
            'service_product_ids.*' => 'exists:service_products,id',
            'product_quantities' => 'required|array',
            'product_quantities.*' => 'integer|min:1',
            'service_quantities' => 'required|array',
            'service_quantities.*' => 'integer|min:1',
            'product_prices' => 'required|array',
            'product_prices.*' => 'numeric',
            'userreqtime'=>'nullable|string|max:255',
            'service_prices' => 'required|array',
            'service_prices.*' => 'numeric',
            'selected_slot' => 'required|exists:appointmentslots,id',
            'userreqtime' => 'required|array',  // Validate that 'userreqtime' is an array
            'userreqtime.*' => 'required',  // Validate that each time is in 'H:i' format (24-hour format)
     
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Calculate total amounts
        $totalProductAmount = 0;
        $totalServiceAmount = 0;

        foreach ($validated['service_product_ids'] as $index => $serviceProductId) {
            $productQuantity = $validated['product_quantities'][$index];
            $serviceQuantity = $validated['service_quantities'][$index];
            $productPrice = $validated['product_prices'][$index];
            $servicePrice = $validated['service_prices'][$index];

            $totalProductAmount += $productQuantity * $productPrice;
            $totalServiceAmount += $serviceQuantity * $servicePrice;
        }

        $grandTotal = $totalProductAmount + $totalServiceAmount;

        $order = Orders::create([
            'user_id' => Auth::id(),
            'agent_id' => $validated['agent_id'],
            'total_amount' => $grandTotal,
            'order_date' => $validated['date'],
            'userreqtime' => $validated['userreqtime'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['service_product_ids'] as $index => $serviceProductId) {
            OrderProducts::create([
                'order_id' => $order->id,
                'service_product_id' => $serviceProductId,
                'product_quantity' => $validated['product_quantities'][$index],
                'service_quantity' => $validated['service_quantities'][$index],
                'product_price' => $validated['product_prices'][$index],
                'service_price' => $validated['service_prices'][$index],
                'userreqtime' => $validated['userreqtime'][$index],
                'order_date' => $validated['date'][$index],
                'selected_slot' => $validated['selected_slot'],
            ]);
        }

        return response()->json(['message' => 'Order created successfully.','orderid'=> $order->id], 201);
    }
    
    public function paynow(){
        
    }

    /**
     * Display the specified resource.
     */
 public function show(Orders $order)
{
    // Load the related orderProducts, serviceProduct, and payment, and order the orderProducts by ID
    $order->load([
        'orderProducts' => function ($query) {
            $query->orderBy('id', 'asc'); // Sorting orderProducts by ID
        },
        'orderProducts.serviceProduct', 
        'payment'
    ]);

    return response()->json($order);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $order)
    {
        $this->authorize('update', $order);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'status' => 'required|in:pending,accepted,declined',
            'service_product_ids' => 'required|array',
            'service_product_ids.*' => 'exists:service_products,id',
            'product_quantities' => 'required|array',
            'product_quantities.*' => 'integer|min:1',
            'service_quantities' => 'required|array',
            'service_quantities.*' => 'integer|min:1',
            'product_prices' => 'required|array',
            'product_prices.*' => 'numeric',
            'service_prices' => 'required|array',
            'service_prices.*' => 'numeric',
            'selected_slot' => 'required|exists:appointmentslots,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $order->update([
            'order_date' => $validated['date'],
            'status' => $validated['status'],
        ]);

        // Clear existing order products
        $order->orderProducts()->delete();

        foreach ($validated['service_product_ids'] as $index => $serviceProductId) {
            OrderProducts::create([
                'order_id' => $order->id,
                'service_product_id' => $serviceProductId,
                'product_quantity' => $validated['product_quantities'][$index],
                'service_quantity' => $validated['service_quantities'][$index],
                'product_price' => $validated['product_prices'][$index],
                'service_price' => $validated['service_prices'][$index],
                'selected_slot' => $validated['selected_slot'],
            ]);
        }

        return response()->json(['message' => 'Order updated successfully.']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $order)
    {
        // Ensure the current agent can only delete their own orders
        $this->authorize('delete', $order);

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Orders $order)
    {
        // Ensure the current agent can only update their own orders
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,declined',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return response()->json(['message' => 'Order status updated successfully.']);
    }
     /**
     * Display a listing of orders by agent ID.
     */
    public function getOrdersByAgentId($agent_id)
    {
        // Ensure that the authenticated user is authorized to access orders of the given agent_id
        $user = Auth::user();
        if ($user->id !== (int)$agent_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $orders = Orders::where('agent_id', $agent_id)
            ->with(['orderProducts.serviceProduct', 'payment'])
            ->get();

            return response()->json([
                "message"=>"Successfully data fetch",
             "data"=>   $orders
            ]);
    }
     /**
     * Display a listing of orders by user ID.
     */
    public function getOrdersByUserId($user_id)
    {
        // Check if the authenticated user is authorized to access orders for the given user_id
        $currentUser = Auth::user();

        // Example authorization check (adjust as needed)
        if ($currentUser->id !== (int)$user_id && !$currentUser->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $orders = Orders::where('user_id', $user_id)
            ->with(['orderProducts.serviceProduct', 'payment'])
            ->get();

        return response()->json([
            "message"=>"Successfully data fetch",
         "data"=>   $orders
        ]);
    }


     /**
     * Display a listing of orders by user ID and status.
     */
    public function getOrdersByUserAndStatus($user_id, $status)
    {
        // Ensure the authenticated user can only access their own orders
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->id !== (int)$user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the status
        $validStatuses = ['pending', 'accepted', 'declined'];
        if (!in_array($status, $validStatuses)) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $orders = Orders::where('user_id', $user_id)
            ->where('status', $status)
            ->with(['orderProducts.serviceProduct', 'payment'])
            ->get();

        return response()->json($orders);
    }
}
