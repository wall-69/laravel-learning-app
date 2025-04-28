<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $paginator = Admin::paginate(30);

        return response()->json($paginator);
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
