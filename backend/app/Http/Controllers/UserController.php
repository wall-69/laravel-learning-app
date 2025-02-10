<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json([
            "user" => $request->user()
        ]);
    }

    public function userById(User $user)
    {
        return response()->json($user);
    }

    public function index()
    {
        return response()->json(User::latest()->get());
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

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "name" => "sometimes|required|string",
            "surname" => "sometimes|required|string",
            "email" => "sometimes|required|email",
            "new_password" => "sometimes|required|min:6",
        ]);


        // Encrypt the new password
        if ($request->has("new_password")) {
            $data["password"] = Hash::make($request->new_password);
        }

        $user->update($data);

        return response()->json([
            "message" => "User was successfully updated!",
            "notifications" => [
                "success" => [
                    $request->user()->is_admin ? "The user was successfully updated!" : "Your details were updated!"
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
