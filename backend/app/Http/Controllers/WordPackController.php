<?php

namespace App\Http\Controllers;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\WordPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WordPackController extends Controller
{
    public function wordPackById(WordPack $wordPack)
    {
        return response()->json($wordPack);
    }

    public function index(Request $request)
    {
        $paginator = WordPack::search($request->search ?? "")->latest()->paginate(30);

        return response($paginator);
    }

    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            "path_id" => "nullable|integer|exists:paths,id",
            "name" => "required|string|min:1|max:60",
            "description" => "required|string|min:10|max:255",
            "visibility" => ["required", Rule::enum(WordPackVisibility::class)],
            "image" => "nullable|image"
        ]);

        // Save image
        if ($request->hasFile("image")) {
            $data["image"] = "storage/" . $request->image->store("img/word-packs/thumbnails", "public");
        }

        // Set type based on the user's role (user - community or admin - official)
        $data["type"] = $request->user()->admin ? WordPackType::OFFICIAL : WordPackType::COMMUNITY;

        // Set the user_id
        $data["user_id"] = $request->user()->id;

        // Create the WordPack
        WordPack::create($data);

        return response()->json([
            "message" => "Word pack was successfully created."
        ]);
    }

    public function update(Request $request, WordPack $wordPack)
    {
        // If it is not the user who created the WordPack or an admin, cancel the request
        if ($request->user()->id != $wordPack->user_id && !$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $data = $request->validate([
            "path_id" => "nullable|integer|exists:paths,id",
            "name" => "required|string|min:1|max:60",
            "description" => "required|string|min:10|max:255",
            "visibility" => ["required", Rule::enum(WordPackVisibility::class)],
            "image" => "nullable|image"
        ]);

        // Save image
        if ($request->hasFile("image") || $request->image == null) {
            // Delete old image, if one is set
            if ($wordPack->image) {
                Storage::disk("public")->delete(str_replace("storage/", "", $wordPack->image));
            }

            if ($request->image) {
                $data["image"] = "storage/" . $request->image->store("img/word-packs/thumbnails", "public");
            } else {
                $data["image"] = null;
            }
        }

        $wordPack->update($data);

        return response()->json([
            "message" => "Word pack was successfully updated.",
            "notifications" => [
                "success" => [
                    "The word pack was successfully updated!"
                ]
            ]
        ]);
    }

    public function destroy(Request $request, WordPack $wordPack)
    {
        // If it is not the user who created the WordPack or an admin, cancel the request
        if ($request->user()->id != $wordPack->user_id && !$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $wordPack->delete();

        return response()->json([
            "message" => "Word pack was successfully deleted.",
            "notifications" => [
                "success" => [
                    "The word pack was successfully deleted!"
                ]
            ]
        ]);
    }
}
