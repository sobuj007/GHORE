<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\OrdersVendoNew;
use App\Models\OrdersItems;
use App\Models\OrdersNew;
use App\Models\ReviewRating;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class OrdersNewController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the request
          $validator = Validator::make($request->all(), [
            'agent_id' => 'required|array',
            // 'date' => 'required|array',
            'service_product_ids' => 'required|array',
            'product_quantities' => 'required|array',
            'service_quantities' => 'required|array',
            'product_prices' => 'required|array',
            'service_prices' => 'required|array',
            'selected_slot' => 'required|array',
            'userreqtime' => 'required|array',
            'req_order_date' => 'required|array',
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
            $req_order_date = $validated['req_order_date'][$index];

            $totalProductAmount += $productQuantity * $productPrice;
            $totalServiceAmount += $serviceQuantity * $servicePrice;
        }

        $grandTotal = $totalProductAmount + $totalServiceAmount;

        // Create the order
        $order = OrdersNew::create([
            'user_id' => auth()->id(),
            'total_amount' => $grandTotal,
            'status' => 'pending',
            'order_date' => now(),
        ]);

        // Loop through each agent to create orders
        foreach ($request->agent_id as $index => $vendorId) {
            // // Create vendor-specific order
            // $orderVendor = OrdersVendoNew::create([
            //     'order_id' => $order->id,
            //     'vendor_id' => $vendorId,
            //     'status' => 'pending',
            // ]);
 if (!isset($request->service_product_ids[$index])) {
        return response()->json(['error' => "Product ID is missing at index $index"], 422);
    }

    $productId = $request->service_product_ids[$index];

    $orderVendor = OrdersVendoNew::create([
        'order_id' => $order->id,
        'vendor_id' => $vendorId,
        'product_id' => $productId,
        'status' => 'pending',
    ]);
            
        }
        // Add all service products for this vendor
            foreach ($request->service_product_ids as $key => $serviceProductId) {
                OrdersItems::create([
                    'order_id' => $order->id,
                    'vendor_id' => $vendorId,
                    'service_product_id' => $serviceProductId,
                    'product_quantity' => $request->product_quantities[$key],
                    'service_quantity' => $request->service_quantities[$key],
                    'product_price' => $request->product_prices[$key],
                    'service_price' => $request->service_prices[$key],
                    'selected_slot' => $request->selected_slot[$key],
                    'userreqtime' => $request->userreqtime[$key],
                    'req_order_date' => $request->req_order_date[$key],
                ]);
            }

        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order
        ]);
    }
    
    
//     public function store(Request $request)
// {
//     // Validate the request
//     $validator = Validator::make($request->all(), [
//         'agent_id' => 'required|array',
//         'service_product_ids' => 'required|array',
//         'product_quantities' => 'required|array',
//         'service_quantities' => 'required|array',
//         'product_prices' => 'required|array',
//         'service_prices' => 'required|array',
//         'selected_slot' => 'required|array',
//         'userreqtime' => 'required|array',
//         'req_order_date' => 'required|array',
//     ]);

//     // Check for validation errors
//     if ($validator->fails()) {
//         return response()->json($validator->errors(), 422);
//     }

//     // Validate that all arrays have the same length
//     $numItems = count($request->service_product_ids);
//     if ($numItems != count($request->product_quantities) || $numItems != count($request->service_quantities) || $numItems != count($request->product_prices) || $numItems != count($request->service_prices)) {
//         return response()->json(['error' => 'Mismatched array lengths.'], 422);
//     }

//     // Start a database transaction to ensure atomic operations
//     DB::beginTransaction();

//     try {
//         // Calculate total amounts
//         $totalProductAmount = 0;
//         $totalServiceAmount = 0;

//         foreach ($request->service_product_ids as $index => $serviceProductId) {
//             $productQuantity = $request->product_quantities[$index];
//             $serviceQuantity = $request->service_quantities[$index];
//             $productPrice = $request->product_prices[$index];
//             $servicePrice = $request->service_prices[$index];

//             $totalProductAmount += $productQuantity * $productPrice;
//             $totalServiceAmount += $serviceQuantity * $servicePrice;
//         }

//         $grandTotal = $totalProductAmount + $totalServiceAmount;

//         // Create the main order
//         $order = OrdersNew::create([
//             'user_id' => auth()->id(),
//             'total_amount' => $grandTotal,
//             'status' => 'pending',
//             'order_date' => now(),
//         ]);

//         // Loop through each agent to create orders and add to vendor news
//         foreach ($request->agent_id as $index => $vendorId) {
//             // Create vendor-specific order
//             $orderVendor = OrdersVendoNew::create([
//                 'order_id' => $order->id,
//                 'vendor_id' => $vendorId,
//                 'status' => 'pending',
//                 'product_id' => $request->service_product_ids[$index], // Add product_id to vendor order
//             ]);

//             // Add all service products for this vendor
//             foreach ($request->service_product_ids as $key => $serviceProductId) {
//                 OrdersItems::create([
//                     'order_id' => $order->id,
//                     'vendor_id' => $vendorId,
//                     'service_product_id' => $serviceProductId,
//                     'product_quantity' => $request->product_quantities[$key],
//                     'service_quantity' => $request->service_quantities[$key],
//                     'product_price' => $request->product_prices[$key],
//                     'service_price' => $request->service_prices[$key],
//                     'selected_slot' => $request->selected_slot[$key],
//                     'userreqtime' => $request->userreqtime[$key],
//                     'req_order_date' => $request->req_order_date[$key],
//                 ]);
//             }
//         }

//         // Commit the transaction if everything was successful
//         DB::commit();

//         return response()->json([
//             'message' => 'Order created successfully!',
//             'order' => $order
//         ]);
//     } catch (\Exception $e) {
//         // Rollback the transaction in case of an error
//         DB::rollBack();
        
//         // Return the error message
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }



 public function updateProductStatus(Request $request, $orderId)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:complete,accept', // Allowed statuses
            'product_id' => 'required|exists:orders_vendo_news,product_id', // Ensure product_id exists
        ]);

        // Fetch the item that matches both order_id and product_id and update its status
        $orderItem = OrdersVendoNew::where('order_id', $orderId)
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($orderItem) {
            $orderItem->status = $request->input('status');
            $orderItem->save();

            return response()->json([
                'message' => 'Order item status updated successfully',
                'data' => $orderItem
            ], 200);
        } else {
            return response()->json(['error' => 'Order item not found'], 404);
        }
    }
// public function getVendorOrdersOverview(Request $request, $vendorId)
// {
//     // Format today's date as `d/m/Y` to match the format of `req_order_date`
//     $today = now()->format('d/m/Y');

//     // Fetch completed orders
//     $completedOrders = OrdersNew::whereHas('vendorOrders', function ($q) use ($vendorId) {
//         $q->where('vendor_id', $vendorId)
//           ->where('status', 'complet');
//     })->with(['user:id,name,email', 'user.commonProfile', 'items2', 'vendorOrders','payment'])
//       ->get();
      
      
//     $completedBalance = $completedOrders->sum(function ($order) {
//         return $order->items2->sum(function ($item) {
//             return ($item->service_price * $item->service_quantity) + ($item->product_price * $item->product_quantity);
//         });
//     });

//     // Fetch pending orders
//     $pendingOrders = OrdersNew::whereHas('vendorOrders', function ($q) use ($vendorId) {
//         $q->where('vendor_id', $vendorId)
//           ->where('status', 'pending');
//     })->with(['user:id,name,email', 'user.commonProfile', 'items2', 'vendorOrders','payment'])
//       ->get();
//  $pendingBalance = $pendingOrders->sum(function ($order) {
//         return $order->items2->sum(function ($item) {
//             return ($item->service_price * $item->service_quantity) + ($item->product_price * $item->product_quantity);
//         });
//     });

// // Calculate total balance (completed + pending)
//     $totalBalance = $completedBalance + $pendingBalance;

//     // Fetch today's orders based on trimmed `req_order_date`
//     $todayOrderItems = OrdersItems::whereHas('order', function ($query) use ($today) {
//         $query->whereRaw("TRIM(req_order_date) = ?", [$today]); // Trim any extra spaces
//     })
//     ->where('vendor_id', $vendorId) // Filter items by vendor ID
//     ->with(['order.user.commonProfile','order.items2','order.vendorOrders','order.payment']) // Include related data
//     ->get();

    
//     // Return JSON response with completed, pending, and today's orders
//   return response()->json([
//         'message' => 'Vendor orders found successfully!',
//         'completedOrders' => $completedOrders,
//         'pendingOrders' => $pendingOrders,
//         'todayOrders' => $todayOrderItems,
//         'completedBalance' => $completedBalance,
//         'pendingBalance' => $pendingBalance,
//         'totalEarnings' => $totalBalance,
//     ]);
// }



public function getVendorOrdersOverview(Request $request, $vendorId)
{
    // Format today's date as `d/m/Y` to match the format of `req_order_date`
    $today = now()->format('d/m/Y');

    // Fetch pending orders
    $pendingOrders = OrdersNew::whereHas('vendorOrders', function ($q) use ($vendorId) {
        $q->where('vendor_id', $vendorId);
        //  ->where('status', 'pending');
    })->with(['user:id,name,email', 'user.commonProfile', 'items2', 'vendorOrders', 'payment'])
      ->get();


    
    $pendingBalance = $pendingOrders->sum(function ($order) {
        return $order->items2->sum(function ($item) {
            return ($item->service_price * $item->service_quantity) + ($item->product_price * $item->product_quantity);
        });
    });

    // Fetch today's orders based on trimmed `req_order_date`
    $todayOrderItems = OrdersItems::whereHas('order', function ($query) use ($today) {
        $query->whereRaw("TRIM(req_order_date) = ?", [$today]); // Trim any extra spaces
    })
    ->where('vendor_id', $vendorId) // Filter items by vendor ID
    ->with(['order.user.commonProfile', 'order.items2', 'order.vendorOrders', 'order.payment']) // Include related data
    ->get();

    // Return JSON response with pending orders and today's orders
    return response()->json([
        'message' => 'Vendor orders found successfully!',
        'pendingOrders' => $pendingOrders,
        'todayOrders' => $todayOrderItems,
        'pendingBalance' => $pendingBalance,
    ]);
}


    public function findUserOrdersByStatus(Request $request)
{
    // Validate the request to ensure 'user_id' is provided and exists in the users table
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Get the user ID from the request
    $user_id = $request->input('user_id');

    // Find completed orders with associated order items and service product information
    $completedorders = OrdersNew::with(['items2.serviceProduct2']) // Eager load items and service product
                                ->where('user_id', $user_id)
                                ->where('status', 'completed')
                                ->get();

    // Find pending orders with associated order items and service product information
    $pendingorders = OrdersNew::with(['items2.serviceProduct2']) // Eager load items and service product
                                ->where('user_id', $user_id)
                                ->where('status', 'pending')
                                ->get();

    // Find today's orders with associated order items and service product information
    $today = now()->format('Y-m-d');
    $todaylist = OrdersNew::with(['items2.serviceProduct2']) // Eager load items and service product
                            ->where('user_id', $user_id)
                            ->where('order_date', $today)
                            ->get();

    // Return response with the orders and attached service product data
    return response()->json([
        'message' => 'Orders found successfully!',
        'completedorders' => $completedorders,
        'pendingorders' => $pendingorders,
        'todaylist' => $todaylist
    ]);
        }
public function storereview(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'serviceproduct_id' => 'nullable|exists:service_products,id',
            'agent_id' => 'nullable|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'reviewername' => 'required|string|max:255',
            'image' => 'nullable|string|max:2048',
        ]);

        // Handle image upload
        // $image = null;
        // if ($request->hasFile('image')) {
        //     $image = getImageName($request->file('image')->getClientOriginalName());
        //     $request->file('image')->storeAs('reviews', $image); // Store image in 'reviews' folder
        // }

        // Create a new review
        $reviewRating = ReviewRating::create([
            'user_id' => auth()->id(),
            'reviewername' => $request->reviewername,
            'image' =>$request->image,
            'serviceproduct_id' => $request->serviceproduct_id,
            'agent_id' => $request->agent_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Return JSON response for API
        return response()->json([
            'message' => 'Review added successfully',
            'data' => $reviewRating
        ], 201); // 201 status for created
    }

    // Get reviews by agent_id (API)
    public function getReviewsByAgent($agent_id)
    {
        // Fetch reviews for the specified agent
        $reviews = ReviewRating::where('agent_id', $agent_id)->get();

        // Return JSON response with reviews data
        return response()->json([
            'message' => 'Reviews fetched successfully',
            'reviews' => $reviews
        ], 200); // 200 status for success
    }


public function getVendorOrdersOverview2(Request $request, $vendorId)
{
    $today = now()->format('d/m/Y');

    // Fetch all orders for the vendor
    $orders = OrdersItems::where('vendor_id', $vendorId)
        ->with(['user:id,name,email', 'user.commonProfile', 'items2',  'payment'])
        ->get();

    // Filter orders
    $pendingOrders = $orders->where('status', 'pending');
    $todaysOrders = $orders->where('req_order_date', $today);

    // Calculate balances
    $pendingBalance = $pendingOrders->sum(function ($order) {
        return ($order->product_quantity * $order->product_price) +
               ($order->service_quantity * $order->service_price);
    });

    $completedBalance = $orders->where('status', 'completed')->sum(function ($order) {
        return ($order->product_quantity * $order->product_price) +
               ($order->service_quantity * $order->service_price);
    });

    // Prepare the response
    return response()->json([
        'pending_orders' => $pendingOrders->values(),
        'todays_orders' => $todaysOrders->values(),
        'pending_balance' => $pendingBalance,
        'completed_balance' => $completedBalance,
    ]);
}



}

