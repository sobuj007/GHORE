<?php

namespace App\Http\Controllers\Api;

use App\Models\Myslot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyslotApiController extends Controller
{
    public function index()
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();

        return response()->json([
            'message' => 'Successful',
            'data' => $myslots
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'available_opening' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'offday' => 'required|string|max:255',
            'active' => 'required|boolean',
            'slot_duration' => 'required|integer',
        ]);

        $myslot = Myslot::create([
            'agent_id' => Auth::id(),
            'available_opening' => $request->available_opening,
            'title' => $request->title,
            'offday' => $request->offday,
            'active' => $request->active,
            'slot_duration' => $request->slot_duration,
        ]);

        return response()->json([
            'message' => 'Slot created successfully.',
            'data' => $myslot
        ], 201);
    }

    public function show(Myslot $myslot)
    {
        if ($myslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Successful',
            'data' => $myslot
        ], 200);
    }

    public function update(Request $request, Myslot $myslot)
    {
        if ($myslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'available_opening' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'offday' => 'required|string|max:255',
            'active' => 'required|boolean',
            'slot_duration' => 'required|integer',
        ]);

        $myslot->update([
            'available_opening' => $request->available_opening,
            'title' => $request->title,
            'offday' => $request->offday,
            'active' => $request->active,
            'slot_duration' => $request->slot_duration,
        ]);

        return response()->json([
            'message' => 'Slot updated successfully.',
            'data' => $myslot
        ], 200);
    }

    public function destroy(Myslot $myslot)
    {
        if ($myslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $myslot->delete();

        return response()->json([
            'message' => 'Slot deleted successfully.',
        ], 200);
    }
}
