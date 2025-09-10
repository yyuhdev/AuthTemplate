<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return [
                'success' => false,
                'message' => "Invalid Credentials; Internal Error.",
            ];
        }

        $user = Auth::user();
        $request->session()->regenerate();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->withAccessToken($token);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'identification' => 'required|string',
            'password' => 'required',
        ]);

        $field = filter_var($request->identification, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (!Auth::attempt([
            $field     => $request->identification,
            'password' => $request->password,
        ])) {
            return response()->json([
                "success" => false,
                "message" => "Invalid Credentials",
            ], 401);
        }

        $user = Auth::user();
        $request->session()->regenerate();

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->withAccessToken($token);

        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }
}
