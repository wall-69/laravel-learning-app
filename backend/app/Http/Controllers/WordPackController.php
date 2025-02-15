<?php

namespace App\Http\Controllers;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\WordPack;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WordPackController extends Controller
{

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
        // TODO: replace true with real condition
        $data["type"] = true ? WordPackType::OFFICIAL : WordPackType::COMMUNITY;

        // Create the WordPack
        WordPack::create($data);

        return response()->json([
            "message" => "Word pack successfully created."
        ]);
    }
}
