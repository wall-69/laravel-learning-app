<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "user_id" => "required|exists:users,id|unique:admins"
        ]);

        Admin::create($data);

        return response()->json([
            "message" => "Admin was successfully created.",
        ]);
    }

    public function destroy(Request $request, Admin $admin)
    {
        $admin->delete();

        return response()->json([
            "message" => "Admin was successfully deleted.",
            "notifications" => [
                "success" => [
                    "The user is no longer an admin."
                ]
            ]
        ]);
    }
}
