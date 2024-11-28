<?php

namespace App\Http\Controllers\Agent;

use App\Models\MyExpart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyExpartController extends Controller
{public function index()
    {
        $experts = MyExpart::where('agent_id', Auth::id())->get();
        return view('agent.myexparts.index', compact('experts'));
    }

    public function create()
    {
        return view('agent.myexparts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'required|image|max:2048',
            'expartyear' => 'required|integer',
            'gender' => 'required|string',
            'mobile' => 'required|string|max:15',
            'certificate_images.*' => 'image|max:2048',
        ]);

        // $profileImage = $request->file('profile_image')->store('exparts', 'public');
        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = getImageName($request->file('profile_image')->getClientOriginalName());
            $request->file('profile_image')->storeAs('exparts', $profileImage);
        }
        $certificateImages = [];
if ($request->hasFile('certificate_images')) {
    foreach ($request->file('certificate_images') as $image) {
        // Get the original name of each certificate image and create a new name for storage
        $imageName = getImageName($image->getClientOriginalName());
        // Store the certificate image in the 'expartscertificate' directory on the 'public' disk
        $image->storeAs('expartscertificate', $imageName);
        // Add the stored image path to the $certificateImages array
        $certificateImages[] = $imageName;
    }
}

        MyExpart::create([
            'agent_id' => Auth::id(),
            'name' => $request->name,
            'profile_image' => $profileImage,
            'expartyear' => $request->expartyear,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'certificate_images' => json_encode($certificateImages),
        ]);

        return redirect()->route('myexparts.index')->with('success', 'Expert added successfully.');
    }

    public function edit( $myExpart)

    {$myexpart=MyExpart::find($myExpart);
        return view('agent.myexparts.edit', compact('myexpart'));
    }

    public function update(Request $request, MyExpart $myExpart)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'expartyear' => 'required|integer',
            'gender' => 'required|string',
            'mobile' => 'required|string|max:15',
            'certificate_images.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')->store('uploads/expartsImage', 'public');
        } else {
            $profileImage = $myExpart->profile_image;
        }

        $certificateImages = $myExpart->certificate_images;
        if ($request->hasFile('certificate_images')) {
            $certificateImages = [];
            foreach ($request->file('certificate_images') as $image) {
                $certificateImages[] = $image->store('uploads/expartsImage', 'public');
            }
        }

        $myExpart->update([
            'name' => $request->name,
            'profile_image' => $profileImage,
            'expartyear' => $request->expartyear,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'certificate_images' => json_encode($certificateImages),
        ]);

        return redirect()->route('myexparts.index')->with('success', 'Expert updated successfully.');
    }

    public function destroy( $myExpart)
    {
        $myExpart= MyExpart::find($myExpart);
        $myExpart->delete();
        return redirect()->route('myexparts.index')->with('success', 'Expert deleted successfully.');
    }
}
