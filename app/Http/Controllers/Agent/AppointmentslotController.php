<?php

namespace App\Http\Controllers\Agent;

use App\Models\Myslot;
use Illuminate\Http\Request;
use App\Models\Appointmentslot;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class AppointmentslotController extends Controller
{
    public function index()
    {
        $appointmentslots = Appointmentslot::where('agent_id', Auth::id())->get();
        return view('agent.appointmentslots.index', compact('appointmentslots'));
    }

    public function create()
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();
        return view('agent.appointmentslots.create', compact('myslots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:myslots,id',
            'time' => 'required',
            'note' => 'nullable|string',
        ]);

        Appointmentslot::create([
            'slot_id' => $request->slot_id,
            'agent_id' => Auth::id(),
            'time' => $request->time,
            'note' => $request->note,
        ]);

        return redirect()->route('appointmentslots.index')->with('success', 'Appointment Slot created successfully.');
    }

    public function edit(Appointmentslot $appointmentslot)
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();
        $agents= User::where('id', Auth::id())->get();;
        return view('agent.appointmentslots.edit', compact('appointmentslot', 'myslots','agents'));
    }

    public function update(Request $request, Appointmentslot $appointmentslot)
    {
        $request->validate([
            'slot_id' => 'required|exists:myslots,id',
            'time' => 'required',
            'note' => 'nullable|string',
        ]);

        $appointmentslot->update([
            'slot_id' => $request->slot_id,
            'time' => $request->time,
            'note' => $request->note,
        ]);

        return redirect()->route('appointmentslots.index')->with('success', 'Appointment Slot updated successfully.');
    }

    public function destroy(Appointmentslot $appointmentslot)
    {
        $appointmentslot->delete();
        return redirect()->route('appointmentslots.index')->with('success', 'Appointment Slot deleted successfully.');
    }
}
