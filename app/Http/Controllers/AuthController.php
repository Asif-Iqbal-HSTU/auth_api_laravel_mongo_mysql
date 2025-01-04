<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'role' => 'required',
                'password' => 'required|min:8',
                'profile.name' => 'required',
                'profile.email' => 'required|email',
                'profile.address' => 'required',
            ]);


            $user = User::create([
                'username' => $request->username,
                'role' => $request->role,
            ]);


            Profile::create([
                'user_id' => $user->id,
                'password' => Hash::make($request->password),
                'profile_data' => $request->profile,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user_id' => $user->id,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while creating the user', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('username', $request->username)->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Invalid username or password'], 401);
            }

            $profile = Profile::where('user_id', $user->id)->first();

            if (!Hash::check($request->password, $profile->password)) {
                return response()->json(['success' => false, 'message' => 'Invalid username or password'], 401);
            }

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'profile' => $profile->profile_data,
                ],
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred during login', 'error' => $e->getMessage()], 500);
        }
    }
}
