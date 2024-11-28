<?php

namespace App\Http\Controllers\Agent;

use App\Models\City;
use App\Models\Myslot;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\Location;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\ServiceProduct;
use App\Models\Appointmentslot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceProductController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceProducts = ServiceProduct::where('agent_id', Auth::id())->get();
        return view('agent.serviceproducts.index', compact('serviceProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $cities = City::all();
        $slots = Myslot::where('agent_id', Auth::id())->get();
        return view('agent.serviceproducts.create', compact('categories', 'cities', 'slots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('servicesproduct', $imageName);
        }

        $serviceProduct = ServiceProduct::create([
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
        'slot_id' => $validated['available_slot_id'],
        'appointment_slot_ids' => json_encode($validated['appointment_slot_ids'] ?? []),
        'location_ids' => json_encode($validated['location_ids']), // Encode array to JSON
        'agent_id' => Auth::id(),
        ]);

        $serviceProduct->location()->sync($validated['location_ids']);
        $serviceProduct->appointmentSlots()->sync($validated['appointment_slot_ids']);

        return redirect()->route('serviceproducts.index')->with('success', 'Service Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceProduct $serviceproduct)
    {
        $categories = Category::all();
        $cities = City::all();
        $slots = Myslot::where('agent_id', Auth::id())->get();
        return view('agent.serviceproducts.edit', compact('serviceproduct', 'categories', 'cities', 'slots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceProduct $serviceProduct)
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

        return redirect()->route('serviceproducts.index')->with('success', 'Service Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $serviceProduct)
    {
        $serviceProduct=ServiceProduct::find($serviceProduct);
        $serviceProduct->delete();

        return redirect()->route('serviceproducts.index')->with('success', 'Service Product deleted successfully.');
    }
    public function getSubcategories(Request $request)
{
    $subcategories = Subcategory::where('category_id', $request->category_id)->get();
    return response()->json($subcategories);
}

public function getBodyParts(Request $request)
{
    $bodyParts = BodyPart::where('subcategory_id', $request->subcategory_id)->get();
    return response()->json($bodyParts);
}

public function getLocations(Request $request)
{
    $locations = Location::where('city_id', $request->city_id)->get();
    return response()->json($locations);
}

public function getAppointmentSlots(Request $request)
{
    $appointmentSlots = Appointmentslot::where('slot_id', $request->slot_id)->get();
    return response()->json($appointmentSlots);
}
}
