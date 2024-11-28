<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Models\Storeprofile;
use App\Models\MyExpart;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceProduct;
use App\Models\OrdersVendoNew;
use App\Models\OrdersItems;
use App\Models\OrdersNew;
use Illuminate\Support\Facades\Auth;

class StoreprofileApiController extends Controller
{

    public function index()
    {
        // List all store profiles for the authenticated agent
        $profiles = Storeprofile::where('agent_id', Auth::id())->get();
        
   
        return response()->json([
            'message' => 'Successfully retrieved store profiles.',
            'data' => $profiles,
           
        ]);
    }
    public function indexget()
    {
        // List all store profiles for the authenticated agent
        $profiles = Storeprofile::all();
        return response()->json([
            'message' => 'Successfully retrieved store profiles.',
            'data' => $profiles
        ]);
    }
  public function agentprofile($request)
    {
        // List all store profiles for the authenticated agent
        $profiles = Storeprofile::where('agent_id', $request)->get();
        $certificate = Certificate::where('agent_id', $request)->get();
        $exparts = MyExpart::where('agent_id', $request)->get();
        $product = ServiceProduct::where('agent_id', $request)->get();
               // Count the number of orders for the given vendor
    $orderCount = OrdersItems::where('vendor_id', $request)  // Assuming 'agent_id' or 'vendor_id' is used
                            ->count();
        return response()->json([
            'message' => 'Successfully retrieved store profiles.',
            'profiles' => $profiles,
            'exparts'=>$exparts,
            'certificate'=>$certificate,
            'products' => $product,
             "totalorder"=>$orderCount
        ]);
    }
      public function agentrecomendation($request)
    {
        // List all store profiles for the authenticated agent
        $product = ServiceProduct::where('agent_id', $request)->get();
        
        return response()->json([
            'message' => 'Successfully retrieved store profiles.',
            'products' => $product,
            
        ]);
    }

   public function store(Request $request)
{
    $request->validate([
        'storename' => 'required|string|max:255',
        'coverImage' => 'nullable|image|max:2048',
        'tradelicence' => 'nullable|string|max:255',
        'servicestime' => 'nullable|string|max:255',
        'address' => 'required|string|max:255',
        'mobile' => 'required|string|max:15',
        'logo' => 'nullable|image|max:2048',
        'city_id' => 'required|exists:cities,id',
        'location_ids' => 'required|array',
        'location_ids.*' => 'exists:locations,id',
        'nid' => 'nullable|string|max:20',
        'company_type' => 'required|string',
    ]);

    // Handle cover image upload
    $coverimage = $request->hasFile('coverImage') ? getImageName($request->file('coverImage')->getClientOriginalName()) : null;
    if ($coverimage) {
        $request->file('coverImage')->storeAs('storeImages', $coverimage);
    }

    // Handle logo image upload
    $logoimage = $request->hasFile('logo') ? getImageName($request->file('logo')->getClientOriginalName()) : null;
    if ($logoimage) {
        $request->file('logo')->storeAs('storeImages', $logoimage);
    }

    Storeprofile::create([
        'storename' => $request->storename,
        'coverImage' => $coverimage,
        'tradelicence' => $request->tradelicence ?? '',
        'servicestime' => $request->servicestime ?? '',
        'address' => $request->address,
        'mobile' => $request->mobile,
        'logo' => $logoimage,
        'city_id' => $request->city_id,
        'location_ids' => json_encode($request->location_ids),
        'nid' => $request->nid ?? '',
        'company_type' => $request->company_type,
        'agent_id' => Auth::id(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Store profile created successfully.'
    ]);
}


    public function show($id)
    {
        // Get a single store profile by ID
        $profile = Storeprofile::where('agent_id', Auth::id())->findOrFail($id);
        return response()->json([
            'message' => 'Successfully retrieved store profile.',
            'data' => $profile
        ]);
    }

    public function update(Request $request, $id)
    {
        $profile = Storeprofile::where('agent_id', Auth::id())->findOrFail($id);

        $request->validate([
            'storename' => 'required|string|max:255',
            'coverImage' => 'nullable|image|max:2048',
            'tradelicence' => 'nullable|string|max:255',
            'servicestime' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'logo' => 'nullable|image|max:2048',
            'city_id' => 'required|exists:cities,id',
            'location_ids' => 'required|array',
            'location_ids.*' => 'exists:locations,id',
            'nid' => 'nullable|string|max:20',
            'company_type' => 'required|string',
        ]);

        // // Handle cover image upload
        // if ($request->hasFile('coverImage')) {
        //     if ($profile->coverImage) {
        //         Storage::disk('public')->delete($profile->coverImage);
        //     }
        //     $profile->coverImage = $request->file('coverImage')->store('storeImages', 'public');
        // }

        // // Handle logo image upload
        // if ($request->hasFile('logo')) {
        //     if ($profile->logo) {
        //         Storage::disk('public')->delete($profile->logo);
        //     }
        //     $profile->logo = $request->file('logo')->store('storeImages', 'public');
        // }
        $coverimage=$request->coverimage;
        if(!empty($request->file('coverImage'))){
            $coverimage=getImageName($request->file('coverImage')->getClientOriginalName());
            $request->file('coverImage')->storeAs('storeImages',$coverimage);
        }
        $logoimage=$request->logo;
        if(!empty($request->file('logo'))){
            $logoimage=getImageName($request->file('logo')->getClientOriginalName());
            $request->file('logo')->storeAs('storeImages',$logoimage);
        }
        $profile->update([
            'storename' => $request->storename,
            'coverImage' => $profile->coverImage,
            'tradelicence' => $request->tradelicence,
            'servicestime' => $request->servicestime,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'logo' => $profile->logo,
            'city_id' => $request->city_id,
            'location_ids' => json_encode($request->location_ids),
            'nid' => $request->nid,
            'company_type' => $request->company_type,
        ]);

        return response()->json([
            'message' => 'Store profile updated successfully.',
            'data' => $profile
        ]);
    }

    public function destroy($id)
    {
        $profile = Storeprofile::where('agent_id', Auth::id())->findOrFail($id);



        $profile->delete();

        return response()->json([
            'message' => 'Store profile deleted successfully.'
        ]);
    }

    public function getLocations($cityId)
    {
        $locations = Location::where('city_id', $cityId)->get();
        return response()->json([
            'message' => 'Successfully retrieved locations.',
            'data' => $locations
        ]);
    }
    public function getLatestStoreProfiles($limit )
{
    // Fetch the latest store profiles ordered by created_at in descending order
    $storeProfiles = StoreProfile::orderBy('created_at', 'desc')->take($limit)->get();

    // Map the results to the desired structure
    $data = $storeProfiles->map(function($profile) {
        return [
            "id" => $profile->id,
            "storename" => $profile->storename,
            "coverImage" => $profile->coverImage,
            "agent_id" => $profile->agent_id,
            "tradelicence" => $profile->tradelicence,
            "servicestime" => $profile->servicestime,
            "address" => $profile->address,
            "mobile" => $profile->mobile,
            "logo" => $profile->logo,
            "city" => $profile->city->name, // Assuming there's a relationship with the City model
            "locations" => $profile->locations->pluck('name'), // Assuming there's a relationship with the Location model
            "nid" => $profile->nid,
            "company_type" => $profile->company_type,
            "created_at" => $profile->created_at,
            "updated_at" => $profile->updated_at,
        ];
    });

    // Return the data as a JSON response
    return response()->json($data);
}
}
