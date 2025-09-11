<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function resetPassword(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => __($status),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __($status),
        ], 400);
    }

    public function updatePassword(Request $request) {
        $request->validate([

            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );


        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'success' => true,
                'message' => "Password reset successfully.",
            ], 200)
            : response()->json([
                'success' => false,
                'message' => "Invalid Session. Request a new Link",
            ], 500);
    }

    public function updatePasswordWithoutToken(Request $request) {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials',
            ]);
        }

        $user->password = $request->password;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "Your password has been updated.",
        ]);
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => "Invalid Credentials",
            ], 403);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "Your username has been updated.",
        ]);
    }

}
