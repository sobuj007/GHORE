<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateApiController extends Controller
{
 // Fetch all certificates for the authenticated agent
 public function index()
 {
    $agentId = Auth::id();

    $certificates = Certificate::where('agent_id', $agentId)->get();

    // if ($certificates->isEmpty()) {

    // } else {
    //     \Log::info("Certificates retrieved successfully.");
    // }

    return response()->json([
        'message' => 'Certificates retrieved successfully.',
        'data' => $certificates
    ], 200);
 }

 // Store a new certificate for the authenticated agent
 public function store(Request $request)
 {
     $request->validate([
         'title' => 'nullable|string|max:255',
         'description' => 'nullable|string',
         'image' => 'nullable|image|max:2048',
     ]);

     $imagePath = null;

     if ($request->hasFile('image')) {
         $imagePath = getImageName($request->file('image')->getClientOriginalName());
         $request->file('image')->storeAs('certificates', $imagePath);
     }

     $certificate = Certificate::create([
         'agent_id' => Auth::id(),
         'title' => $request->title,
         'description' => $request->description,
         'image' => $imagePath,
     ]);

     return response()->json([
         'message' => 'Certificate created successfully.',
         'data' => $certificate
     ], 201);
 }

 // Show a single certificate
 public function show(Certificate $certificate)
 {
     // Check if the authenticated agent is the owner of the certificate
     if ($certificate->agent_id !== Auth::id()) {
         return response()->json([
             'message' => 'Unauthorized access.',
             'data' => []
         ], 403);
     }

     return response()->json([
         'message' => 'Certificate retrieved successfully.',
         'data' => $certificate
     ], 200);
 }

 // Update a certificate
 public function update(Request $request, Certificate $certificate)
 {
     // Check if the authenticated agent is the owner of the certificate
     if ($certificate->agent_id !== Auth::id()) {
         return response()->json([
             'message' => 'Unauthorized access.',
             'data' => []
         ], 403);
     }

     $request->validate([
         'title' => 'nullable|string|max:255',
         'description' => 'nullable|string',
         'image' => 'nullable|image|max:2048',
     ]);

     $imagePath = $certificate->image;
     if ($request->hasFile('image')) {
         $imagePath = getImageName($request->file('image')->getClientOriginalName());
         $request->file('image')->storeAs('certificates', $imagePath);
     }

     $certificate->update([
         'title' => $request->title,
         'description' => $request->description,
         'image' => $imagePath,
     ]);

     return response()->json([
         'message' => 'Certificate updated successfully.',
         'data' => $certificate
     ], 200);
 }

 // Delete a certificate
 public function destroy(Certificate $certificate)
 {
     // Check if the authenticated agent is the owner of the certificate
     if ($certificate->agent_id !== Auth::id()) {
         return response()->json([
             'message' => 'Unauthorized access.',
             'data' => []
         ], 403);
     }

     $certificate->delete();

     return response()->json([
         'message' => 'Certificate deleted successfully.',
         'data' => []
     ], 200);
 }
}
