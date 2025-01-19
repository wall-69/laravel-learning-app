<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            "user" => $request->user()
        ]);
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (auth()->attempt($data)) {
            $request->session()->regenerate();

            return response()->json([
                "message" => "Successfully logged in.",
                "user" => auth()->user()
            ]);
        }

        throw ValidationException::withMessages([
            "password" => ["Invalid credentials."]
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            "message" => "Successfully logged out."
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "surname" => "required",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
            "tos" => "accepted"
        ]);

        $user = User::create($data);
        auth()->login($user);

        return response()->json([
            "message" => "User successfully registered!"
        ]);
    }
}
