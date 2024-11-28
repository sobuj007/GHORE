<?php

namespace App\Http\Controllers\Api;

use App\Models\MyExpart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyExpartsApiController extends Controller
{
    public function index()
    {
        $experts = MyExpart::where('agent_id', Auth::id())->get();
        return response()->json(['message' => 'Successful', 'data' => $experts], 200);
    }
      public function getall()
    {
        $experts = MyExpart::all();
        return response()->json(['message' => 'Successful', 'data' => $experts], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'expartyear' => 'required|integer',
            'gender' => 'required|string',
            'mobile' => 'required|string|max:15',
            'certificate_images.*' => 'image|max:2048',
        ]);

        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = getImageName($request->file('profile_image')->getClientOriginalName());
            $request->file('profile_image')->storeAs('exparts', $profileImage);
        }

        $certificateImages = [];
        if ($request->hasFile('certificate_images')) {
            foreach ($request->file('certificate_images') as $image) {
                $imageName = getImageName($image->getClientOriginalName());
                $image->storeAs('expartscertificate', $imageName);
                $certificateImages[] = $imageName;
            }
        }

        $expert = MyExpart::create([
            'agent_id' => Auth::id(),
            'name' => $request->name,
            'profile_image' => $profileImage,
            'expartyear' => $request->expartyear,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'certificate_images' => json_encode($certificateImages),
        ]);

        return response()->json(['message' => 'Expert added successfully.', 'data' => $expert], 201);
    }

    public function show($myExpart)
    {
        $expert = MyExpart::findOrFail($myExpart);

        if ($expert->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        return response()->json(['message' => 'Successful', 'data' => $expert], 200);
    }

    public function update(Request $request, $myExpart)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'expartyear' => 'required|integer',
            'gender' => 'required|string',
            'mobile' => 'required|string|max:15',
            'certificate_images.*' => 'image|max:2048',
        ]);

        $expert = MyExpart::findOrFail($myExpart);

        if ($expert->agent_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized access.'], 403);
        }

        if ($request->hasFile('profile_image')) {
            $profileImage = getImageName($request->file('profile_image')->getClientOriginalName());
            $request->file('profile_image')->storeAs('exparts', $profileImage);
        } else {
            $profileImage = $expert->profile_image;
        }

        $certificateImages = json_decode($expert->certificate_images, true);
        if ($request->hasFile('certificate_images')) {
            $certificateImages = [];
            foreach ($request->file('certificate_images') as $image) {
                $imageName = getImageName($image->getClientOriginalName());
                $image->storeAs('expartscertificate', $imageName);
                $certificateImages[] = $imageName;
            }
        }

        $expert->update([
            'name' => $request->name,
            'profile_image' => $profileImage,
            'expartyear' => $request->expartyear,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'certificate_images' => json_encode($certificateImages),
        ]);

        return response()->json(['message' => 'Expert updated successfully.', 'data' => $expert], 200);
    }

    public function destroy($myExpart)
    {
        // $expert = MyExpart::find($myExpart);

        // // if ($expert->agent_id !== Auth::id()) {
        // //     return response()->json(['message' => 'Unauthorized access.'], 403);
        // // }

        // $expert->delete();

        // return response()->json(['message' => 'Expert deleted successfully.'], 200);
        $expert = MyExpart::findOrFail($myExpart);

    // Delete the expert
    $expert->delete();

    return response()->json([
        'message' => 'Expert deleted successfully.'], 200);
    }
}
