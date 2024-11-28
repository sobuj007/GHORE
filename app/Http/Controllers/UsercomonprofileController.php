<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Usercomonprofile;
use Illuminate\Support\Facades\Auth;

class UsercomonprofileController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $profile = Usercomonprofile::findOrFail($id);
        // auth()->user()->profile;


        return view('usercommonprofile.index', compact('profile'));
    }

    public function create()
    {
        $id = Auth::user()->id;
        $users = User::findOrFail($id);
        return view('usercommonprofile.create', compact('users'));
    }

    public function store(Request $request)
    {


        $request->validate([

            'img' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'mobilenumber' => 'required|string|max:12',
        ]);


        $image = null;
        if (!empty($request->file('img'))) {
            $image = getImageName($request->file('img')->getClientOriginalName());
            $request->file('img')->storeAs('profile', $image);
        }


        Usercomonprofile::create([
            'user_id' => Auth::user()->id,

            'img' => $image,
            'address' => $request->address,
            'mobilenumber' => $request->mobilenumber,
        ]);;

        return redirect()->route('usercommonprofile.index')->with('success', 'Profile created successfully.');
    }

    public function edit()
    {

        return view('usercommonprofile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'img' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'mobilenumber' => 'nullable|string|max:15',
        ]);

        /**
         * @var User $user
         */
        $user = auth()->user();
        $image = $user->profile->img;
        if (!empty($request->file('img'))) {
            $image = str_replace(' ', '-', time() . '-' . $request->file('img')->getClientOriginalName());
            $request->file('img')->storeAs('profile', $image);
        }
        $user->profile()->update(array_merge($request->only('address', 'mobilenumber'), ['img' => $image]));

        return redirect()->route('usercommonprofile.index')->with('success', 'Profile updated successfully.');
    }

    public function distory($id)
    {
        $profile = Usercomonprofile::findOrFail($id);

        // if ($profile->img) {
        //     \Storage::delete('public/' . $profile->img);
        // }

        $profile->delete();

        return redirect()->route('usercommonprofile.index')->with('success', 'Profile deleted successfully.');
    }
}
