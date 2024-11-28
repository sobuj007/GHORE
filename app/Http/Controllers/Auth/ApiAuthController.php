<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Usercomonprofile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
     // Register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('LaravelPassport')->accessToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
        ]);
    }

    // Login user
    /**
     * Handle user login and issue token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // $user = User::find(1); // Replace with the correct user ID
        // $token = $user->createToken('TestToken')->accessToken;
        // echo $token;
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if (auth()->attempt($request->only('email', 'password'))) {
             $user = User::find(auth()->user()->id);
            // $token = $user->createToken('LaravelPassport')->accessToken;

            $token = $user->createToken('API Token')->plainTextToken;
            $profile = \App\Models\Usercomonprofile::where('user_id', $user->id)->first();
            return response()->json([
                'profile'=>$profile,
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
    public function storePass(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)], 200)
                    : response()->json(['message' => __($status)], 400);
    }
    // Get user and profile data
    public function user(Request $request)
    {
        $user = Auth::user();

        // Assuming you have a Usercommonprofile model
        $profile = \App\Models\Usercomonprofile::where('user_id', $user->id)->first();

        return response()->json([
            'user' => $user,
            'profile' => $profile,
        ]);
    }

}
