<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Function for logging in a user (Web SPA)
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (auth("web")->attempt($data)) {
            $request->session()->regenerate();

            return response()->json([
                "message" => "Successfully logged in.",
            ]);
        }

        throw ValidationException::withMessages([
            "password" => ["Invalid credentials."]
        ]);
    }

    /**
     * Function for logging out a user (Web SPA)
     */
    public function logout(Request $request)
    {
        auth("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            "message" => "Successfully logged out."
        ]);
    }
}
