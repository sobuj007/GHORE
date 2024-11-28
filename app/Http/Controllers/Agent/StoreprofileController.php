<?php

namespace App\Http\Controllers\Agent;

use App\Models\City;
use App\Models\Location;
use App\Models\Storeprofile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoreprofileController extends Controller
{
    public function index()
    {
        $profile = Storeprofile::where('agent_id', Auth::id())->first();
        return view('agent.storeprofile.index', compact('profile'));
    }

 public function create()
    {
        $profile = Storeprofile::where('agent_id', Auth::id())->first();
        if ($profile) {
            return redirect()->route('storeprofile.edit', $profile->id);
        }

        $cities = City::all();
        $locations = Location::all();
        return view('agent.storeprofile.create', compact('cities', 'locations'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'storename' => 'required|string|max:255',
            'coverImage' => 'nullable|image|max:2048',
            'tradelicence' => 'nullable|string|max:255',
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
    $coverimage = null;
    if ($request->hasFile('coverImage')) {
        $coverimage = getImageName($request->file('coverImage')->getClientOriginalName());
        $request->file('coverImage')->storeAs('storeImages', $coverimage);
    }

    // Handle logo image upload
    $logoimage = null;
    if ($request->hasFile('logo')) {
        $logoimage = getImageName($request->file('logo')->getClientOriginalName());
        $request->file('logo')->storeAs('storeImages', $logoimage);
    }

    Storeprofile::create([
        'storename' => $request->storename,
        'coverImage' => $coverimage,
        'tradelicence' => $request->tradelicence,
        'address' => $request->address,
        'mobile' => $request->mobile,
        'logo' => $logoimage,
        'city_id' => $request->city_id,
        'location_ids' => json_encode($request->location_ids),
        'nid' => $request->nid,
        'company_type' => $request->company_type,
        'agent_id' => Auth::id(),
    ]);

    return redirect()->route('storeprofile.index')->with('success', 'Store profile created successfully.');

    }

    public function edit($id)
    {
        $storeProfile = Storeprofile::findOrFail($id);
        if ($storeProfile->agent_id !== Auth::id()) {
            return redirect()->route('storeprofile.index')->with('error', 'You are not authorized to edit this profile.');
        }

        $cities = City::all();
        $locations = Location::all();
        return view('agent/storeprofile.edit', compact('storeProfile', 'cities', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $storeProfile = Storeprofile::where('agent_id', Auth::id())->findOrFail($id);
        $request->validate([
           'storename' => 'required|string|max:255',
            'coverImage' => 'nullable|image|max:2048',
            'tradelicence' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'logo' => 'nullable|image|max:2048',
            'city_id' => 'required|exists:cities,id',
            'location_ids' => 'required|array',
            'location_ids.*' => 'exists:locations,id',
            'nid' => 'nullable|string|max:20',
            'company_type' => 'required|string',    ]);



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

        $storeProfile->update([
            'storename' => $request->storename,
            'coverImage' => $coverimage,
            'tradelicence' => $request->tradelicence,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'logo' => $logoimage,
            'city_id' => $request->city_id,
            'location_ids' => json_encode($request->location_ids),
            'nid' => $request->nid,
            'company_type' => $request->company_type,
        ]);


         return redirect()->route('storeprofile.index')->with('success',"category Created Successfuly");
    }

    public function destroy($id)
    {
        $profile = Storeprofile::findOrFail($id);
        if ($profile->agent_id !== Auth::id()) {
            return redirect()->route('storeprofile.index')->with('error', 'You are not authorized to delete this profile.');
        }



        $profile->delete();

        return redirect()->route('storeprofile.index')->with('success', 'Profile deleted successfully.');
    }

    public function getLocations($cityId)
    {
        $locations = Location::where('city_id', $cityId)->get();
        return response()->json($locations);
    }
}
