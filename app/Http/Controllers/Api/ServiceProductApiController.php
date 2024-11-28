<?php

namespace App\Http\Controllers\Api;

use App\Models\BodyPart;
use App\Models\Location;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\ServiceProduct;
use App\Models\Appointmentslot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceProductApiController extends Controller
{
    public function index()
    {
        $serviceProducts = ServiceProduct::where('agent_id', Auth::id())->get();
        return response()->json([
            'message' => 'Successfully retrieved service products.',
            'data' => $serviceProducts
        ]);
    }
    public function getall()
    {
        $serviceProducts = ServiceProduct::all();
            // Include average rating calculation for each product
    $serviceProductsWithRatings = $serviceProducts->map(function($product) {
        $averageRating = $product->reviewRatings->avg('rating');
        $product->average_rating = $averageRating ?: 0;  // Add 'average_rating' key to each product
        return $product;
    });
        return response()->json([
            'message' => 'Successfully retrieved service products.',
            'products' => $serviceProducts
        ]);
    }

    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'product_price' => 'required|numeric',
        'service_price' => 'required|numeric',
        'gender' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'bodypart_id' => 'required|array',
        'city_id' => 'required|exists:cities,id',
        'location_ids' => 'required|array',
        
    ]);

    // Handle image upload
    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = getImageName($request->file('image')->getClientOriginalName());
        $request->file('image')->storeAs('servicesproduct', $imageName);
    }
    


    // Create the service product
    $serviceProduct = ServiceProduct::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'image' => $imageName,
        'product_price' => $validated['product_price'],
        'service_price' => $validated['service_price'],
        'gender' => $validated['gender'],
        'category_id' => $validated['category_id'],
        'subcategory_id' => $validated['subcategory_id'],
        'bodypart_id' => json_encode($validated['bodypart_id']),
        'city_id' => $validated['city_id'],
        // 'slot_id' => $validated['available_slot_id'],
        // 'appointment_slot_ids' => json_encode($validated['appointment_slot_ids']),
        'location_ids' => json_encode($validated['location_ids']),
        'agent_id' => Auth::id(),
    ]);

    // // Sync relationships
    // $serviceProduct->location()->sync($validated['location_ids']);
    // $serviceProduct->appointmentSlots()->sync($validated['appointment_slot_ids']);

    // Return success response as JSON
    return response()->json([
        'success' => true,
        'message' => 'Service Product created successfully',
        'data' => $serviceProduct
    ], 201);
}

    public function show($id)
    {
        $serviceProduct = ServiceProduct::where('agent_id', Auth::id())->findOrFail($id);
        return response()->json([
            'message' => 'Successfully retrieved service product.',
            'data' => $serviceProduct
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'product_price' => 'required|numeric',
            'service_price' => 'required|numeric',
            'gender' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'bodypart_id' => 'required|exists:body_parts,id',
            'city_id' => 'required|exists:cities,id',
            'location_ids' => 'required|array',
            'available_slot_id' => 'required|exists:myslots,id',
            'appointment_slot_ids' => 'required|array',
        ]);

        $serviceProduct = ServiceProduct::where('agent_id', Auth::id())->findOrFail($id);

        $imageName = $serviceProduct->image;
        if ($request->hasFile('image')) {
            $imageName = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('servicesproduct', $imageName);
        }

        $serviceProduct->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imageName,
            'product_price' => $validated['product_price'],
            'service_price' => $validated['service_price'],
            'gender' => $validated['gender'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'bodypart_id' => $validated['bodypart_id'],
            'city_id' => $validated['city_id'],
            'available_slot_id' => $validated['available_slot_id'],
        ]);

        $serviceProduct->location()->sync($validated['location_ids']);
        $serviceProduct->appointmentSlots()->sync($validated['appointment_slot_ids']);

        return response()->json([
            'message' => 'Service Product updated successfully.',
            'data' => $serviceProduct
        ]);
    }

    public function destroy($id)
    {
        $serviceProduct = ServiceProduct::where('agent_id', Auth::id())->findOrFail($id);



        $serviceProduct->delete();

        return response()->json([
            'message' => 'Service Product deleted successfully.'
        ]);
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json([
            'message' => 'Successfully retrieved subcategories.',
            'data' => $subcategories
        ]);
    }

    public function getBodyParts(Request $request)
    {
        $bodyParts = BodyPart::where('subcategory_id', $request->subcategory_id)->get();
        return response()->json([
            'message' => 'Successfully retrieved body parts.',
            'data' => $bodyParts
        ]);
    }

    public function getLocations(Request $request)
    {
        $locations = Location::where('city_id', $request->city_id)->get();
        return response()->json([
            'message' => 'Successfully retrieved locations.',
            'data' => $locations
        ]);
    }

    public function getAppointmentSlots(Request $request)
    {
        $appointmentSlots = Appointmentslot::where('slot_id', $request->slot_id)->get();
        return response()->json([
            'message' => 'Successfully retrieved appointment slots.',
            'data' => $appointmentSlots
        ]);
    }
    
    //   public function filterByLocations(Request $request)
    // {
    //     // Validate the incoming request to ensure location_ids is an array
    //     $validated = $request->validate([
    //         'location_ids' => 'required|array',
    //         'location_ids.*' => 'integer',  // Ensure each location ID is an integer
    //     ]);

    //     $locationIds = $request->input('location_ids');

    //     // Query to get service products that have matching location_ids
    //     $serviceProducts = ServiceProduct::whereHas('locations2', function ($query) use ($locationIds) {
    //         $query->whereIn('locations.id', $locationIds);
    //     })->with('locations2')->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'nearProduct' => $serviceProducts
    //     ], 200);
    // }
    
    
    public function filterByLocations(Request $request)
{
    // Validate the incoming request to ensure location_ids is an array
    $validated = $request->validate([
        'location_ids' => 'required|array',
        'location_ids.*' => 'integer',  // Ensure each location ID is an integer
    ]);

    $locationIds = $request->input('location_ids');

    // Query to get service products that have matching location_ids
    $serviceProducts = ServiceProduct::whereHas('locations2', function ($query) use ($locationIds) {
        $query->whereIn('locations.id', $locationIds);
    })->with(['locations2', 'reviewRatings'])->get();

    // Include average rating calculation for each product
    $serviceProductsWithRatings = $serviceProducts->map(function($product) {
        $averageRating = $product->reviewRatings->avg('rating');
        $product->average_rating = $averageRating ?: 0;  // Add 'average_rating' key to each product
        return $product;
    });

    return response()->json([
        'status' => 'success',
        'nearProduct' => $serviceProductsWithRatings
    ], 200);
}

}
