<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            "user" => $request->user()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "surname" => "required|string",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
            "tos" => "accepted"
        ]);

        $user = User::create($data);

        return response()->json([
            "message" => "User successfully registered!",
            "notifications" => ["success" => ["Your account was successfully created!"]]
        ]);
    }
}
