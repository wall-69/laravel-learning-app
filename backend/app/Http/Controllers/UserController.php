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

    public function index()
    {
        return response()->json([
            "users" => User::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "surname" => "required|string",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
            "tos" => "sometimes|accepted"
        ]);

        $user = User::create($data);

        return response()->json([
            "message" => "User was successfully registered!",
            "notifications" => [
                "success" => [
                    $request->user()->is_admin ? "The user was successfully created!" : "Your account was successfully created!"
                ]
            ]
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        // Logout the user, if it is not an admin deleting the user
        if (!$request->user()->is_admin) {
            auth("web")->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();

        return response()->json([
            "message" => "User was successfully deleted!",
            "notifications" => [
                "success" => [
                    $request->user()->is_admin ? "The user was successfully deleted!" : "Your account was successfully deleted!"
                ]
            ]
        ]);
    }
}
