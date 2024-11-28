<?php

namespace App\Http\Controllers\Agent;

use App\Models\Myslot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyslotController extends Controller
{public function index()
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();
        return view('agent.myslots.index', compact('myslots'));
    }

    public function create()
    {
        return view('agent.myslots.create');
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

        Myslot::create([
            'agent_id' => Auth::id(),
            'available_opening' => $request->available_opening,
            'title' => $request->title,
            'offday' => $request->offday,
            'active' => $request->active,
            'slot_duration' => $request->slot_duration,
        ]);

        return redirect()->route('myslots.index')->with('success', 'Slot created successfully.');
    }

    public function edit(Myslot $myslot)
    {
        return view('agent.myslots.edit', compact('myslot'));
    }

    public function update(Request $request, Myslot $myslot)
    {
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

        return redirect()->route('myslots.index')->with('success', 'Slot updated successfully.');
    }

    public function destroy(Myslot $myslot)
    {
        $myslot->delete();
        return redirect()->route('myslots.index')->with('success', 'Slot deleted successfully.');
    }
}
