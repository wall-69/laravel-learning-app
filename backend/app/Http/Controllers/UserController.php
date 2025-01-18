<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            "data" => $request->user()
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
