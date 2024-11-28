<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Myslot;
use Illuminate\Http\Request;
use App\Models\Appointmentslot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentslotApiController extends Controller
{
   /**
     * Display a listing of the appointment slots.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $appointmentslots = Appointmentslot::where('agent_id', Auth::id())->get();
        return response()->json([
            'message' => 'Successfully retrieved appointment slots.',
            'data' => $appointmentslots
        ]);
    }

    /**
     * Show the form for creating a new appointment slot.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();
        return response()->json([
            'message' => 'Successfully retrieved slots for creation.',
            'data' => $myslots
        ]);
    }
   

    /**
     * Store a newly created appointment slot in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function store(Request $request)
{
    $request->validate([
        'slot_id' => 'required|exists:myslots,id',
        'time' => 'required|date',
        'note' => 'nullable|string',
    ]);

    $appointmentslot = Appointmentslot::create([
        'slot_id' => $request->slot_id,
        'agent_id' => Auth::id(),
        'time' => $request->time,
        'note' => $request->note,
    ]);

    // Load the related slot details
    $appointmentslot->load('myslot');

    return response()->json([
        'message' => 'Appointment Slot created successfully.',
        'data' => $appointmentslot,
        'slot_details' => $appointmentslot->myslot, // Include slot details in the response
    ], 201);
}

    /**
     * Display the specified appointment slot.
     *
     * @param \App\Models\Appointmentslot $appointmentslot
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointmentslot $appointmentslot)
    {
        // Check if the appointment slot belongs to the authenticated agent
        if ($appointmentslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Successfully retrieved appointment from showslot.',
            'data' => $appointmentslot
        ]);
    }
    public function showBySlotId($slot_id)
{
    // Validate that the slot_id exists
    $appointmentSlots = Appointmentslot::where('slot_id', $slot_id)
                                       ->with('myslot') // Load the related Myslot details
                                       ->get();

    if ($appointmentSlots->isEmpty()) {
        return response()->json([
            'message' => 'No Appointment Slots found for this slot ID.',
        ], 404);
    }

    return response()->json([
        'message' => 'Appointment Slots retrieved successfully.',
        'data' => $appointmentSlots
    ], 200);
}

    /**
     * Show the form for editing the specified appointment slot.
     *
     * @param \App\Models\Appointmentslot $appointmentslot
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Appointmentslot $appointmentslot)
    {
        $myslots = Myslot::where('agent_id', Auth::id())->get();
        $agents = User::where('id', Auth::id())->get();
        return response()->json([
            'message' => 'Successfully retrieved appointment slot for editing.',
            'data' => [
                'appointmentslot' => $appointmentslot,
                'myslots' => $myslots,
                'agents' => $agents
            ]
        ]);
    }

    /**
     * Update the specified appointment slot in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Appointmentslot $appointmentslot
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Appointmentslot $appointmentslot)
    {
        // Check if the appointment slot belongs to the authenticated agent
        if ($appointmentslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'slot_id' => 'required|exists:myslots,id',
            'time' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $appointmentslot->update([
            'slot_id' => $request->slot_id,
            'time' => $request->time,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Appointment Slot updated successfully.',
            'data' => $appointmentslot
        ]);
    }

    /**
     * Remove the specified appointment slot from storage.
     *
     * @param \App\Models\Appointmentslot $appointmentslot
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Appointmentslot $appointmentslot)
    {
        // Check if the appointment slot belongs to the authenticated agent
        if ($appointmentslot->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointmentslot->delete();
        return response()->json([
            'message' => 'Appointment Slot deleted successfully.',
        ]);
    }
}
