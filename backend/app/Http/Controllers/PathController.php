<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;
use Storage;

class PathController extends Controller
{
    public function pathById(Path $path)
    {
        return response()->json($path);
    }

    public function index(Request $request)
    {
        $paginator = Path::search($request->search ?? "")->latest()->paginate(30);

        return response($paginator);
    }

    public function store(Request $request)
    {
        // If it is not the user who created the WordPack or an admin, cancel the request
        if (!$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        // Validate data
        $data = $request->validate([
            "name" => "required|string|min:1|max:60",
            "description" => "required|string|min:10|max:255",
            "image" => "nullable|image"
        ]);

        // Save image
        if ($request->hasFile("image")) {
            $data["image"] = "storage/" . $request->image->store("img/paths/thumbnails", "public");
        }

        // Create the Path
        Path::create($data);

        return response()->json([
            "message" => "Path was successfully created."
        ]);
    }

    public function update(Request $request, Path $path)
    {
        // If it is not an admin, cancel the request
        if (!$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $data = $request->validate([
            "name" => "required|string|min:1|max:60",
            "description" => "required|string|min:10|max:255",
            "image" => "nullable"
        ]);

        // Save image
        if ($request->hasFile("image") || $request->image == null) {
            // Delete old image, if one is set
            if ($path->image) {
                Storage::disk("public")->delete(str_replace("storage/", "", $path->image));
            }

            if ($request->image) {
                $data["image"] = "storage/" . $request->image->store("img/paths/thumbnails", "public");
            } else {
                $data["image"] = null;
            }
        }

        $path->update($data);

        return response()->json([
            "message" => "Path was successfully updated.",
            "notifications" => [
                "success" => [
                    "The path was successfully updated!"
                ]
            ]
        ]);
    }

    public function destroy(Request $request, Path $path)
    {
        // If it is not an admin, cancel the request
        if (!$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $path->delete();

        return response()->json([
            "message" => "Path was successfully deleted.",
            "notifications" => [
                "success" => [
                    "The path was successfully deleted!"
                ]
            ]
        ]);
    }
}
