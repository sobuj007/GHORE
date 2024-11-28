<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('city')->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.locations.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
        ]);

        Location::create($request->only('city_id', 'name'));
        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    public function edit(Location $location)
    {
        $cities = City::all();
        return view('admin.locations.edit', compact('location', 'cities'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
        ]);

        $location->update($request->only('city_id', 'name'));
        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}
