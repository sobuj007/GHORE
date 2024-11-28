<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Usercomonprofile;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsercommonprofileApiController extends Controller
{
    public function index()
    {
        $profiles = Usercomonprofile::where('user_id', Auth::id())->get();

        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'mobilenumber' => 'required|string|max:12',
            'gender' => 'required|string',
        ]);

        $image = null;
        if ($request->hasFile('img')) {
            $image = time() . '-' . $request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('profile', $image);
        }

        $profile = Usercomonprofile::create([
            'user_id' => Auth::id(),
            'img' => $image,
            'address' => $request->address,
            'mobilenumber' => $request->mobilenumber,
            'gender' => $request->gender,
        ]);

        return response()->json($profile, 201);
    }

   public function show($id)
    {
        // Retrieve the user profile by ID
        $profile = Usercomonprofile::where('user_id', $id)->first();

        // Check if the profile exists
        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

 public function update(Request $request)
{
 
    $request->validate([
        'address' => 'nullable|string|max:255',
        'mobilenumber' => 'nullable|string|max:11',
        'img' => 'nullable|image|max:2048',
        'gender' => 'nullable|string',
    ]);

    // Get the authenticated user's profile
    $profile = Usercomonprofile::where('user_id', Auth::id())->first();

    if (!$profile) {
        return response()->json(['message' => 'Profile not found'], 404);
    }

    // Preserve the existing image if no new one is uploaded
    $image = $profile->img;

    // Check if a new image is uploaded
    if ($request->hasFile('img')) {
        // Generate a new image name
        $image = time() . '-' . $request->file('img')->getClientOriginalName();
        // Store the new image in the specified directory
        $request->file('img')->storeAs('profile', $image);
    }

    // Update the profile fields
    
    $profile->update([
        'img' => $image,
        'address' => $request->address ?? $profile->address,
        'mobilenumber' => $request->mobilenumber ?? $profile->mobilenumber,
        'gender' => $request->gender ?? $profile->gender,
    ]);
  
    return response()->json($profile, 200);
}


    public function destroy($id)
    {
        $profile = Usercomonprofile::where('user_id', Auth::id())->findOrFail($id);
        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully.']);
    }
    public function getUserByIdsingel($id)
    {
        // Find the user by ID
        $user = User::find($id);
        $usercommonprofile = Usercomonprofile::where('user_id',$id)->first();

        // Check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Return user data in JSON format
        return response()->json([
            'user' => $user,
            'profile' => $usercommonprofile
        ], 200);
    }
}
