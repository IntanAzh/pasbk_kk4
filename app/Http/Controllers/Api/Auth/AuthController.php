<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        $user->save();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Successfully created user!',
            'access_token' => $tokenResult,
        ], 201);
    }

    public function login(Request $request)
    {
       

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid account',
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('authToken')->plainTextToken;

       

        return response()->json([
            'message' => 'User Berhasil Login',
            'access_token' => $tokenResult,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User Berhasil Logout',
        ], 200);
    }

}
