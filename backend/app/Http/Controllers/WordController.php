<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Storage;

class WordController extends Controller
{
    public function wordById(Word $word)
    {
        return response()->json($word);
    }


    public function index(Request $request)
    {
        $paginator = Word::search($request->search ?? "")->latest()->paginate(30);

        return response($paginator);
    }

    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            "word_pack_id" => "integer|exists:word_packs,id",
            "word" => "string|max:255",
            "word_translation" => "string|max:255",
            "example" => "string|max:255",
            "example_translation" => "string|max:255",
            "explanation" => "string|max:255",
            "image" => "nullable|image"
        ]);

        // Save image
        if ($request->hasFile("image")) {
            $data["image"] = "storage/" . $request->image->store("img/words", "public");
        }

        // Create the Word
        Word::create($data);

        return response()->json([
            "message" => "Word was successfully created."
        ]);
    }

    public function update(Request $request, Word $word)
    {
        // If it is not the user who created the Word or an admin, cancel the request
        if ($request->user()->id != $word->user_id && !$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $data = $request->validate([
            "word_pack_id" => "integer|exists:word_packs,id",
            "word" => "string|max:255",
            "word_translation" => "string|max:255",
            "example" => "string|max:255",
            "example_translation" => "string|max:255",
            "explanation" => "string|max:255",
            "image" => "nullable"
        ]);

        // Save image
        if ($request->hasFile("image") || $request->image == null) {
            // Delete old image, if one is set
            if ($word->image) {
                $filePath = str_replace("storage/", "", $word->image);

                if (Storage::disk("public")->fileExists($filePath)) {
                    Storage::disk("public")->delete($filePath);
                }
            }


            if ($request->image) {
                $data["image"] = "storage/" . $request->image->store("img/words", "public");
            } else {
                $data["image"] = null;
            }
        }

        $word->update($data);

        return response()->json([
            "message" => "Word was successfully updated.",
            "notifications" => [
                "success" => [
                    "The word was successfully updated!"
                ]
            ]
        ]);
    }

    public function destroy(Request $request, Word $word)
    {
        // If it is not the user who created the Word or an admin, cancel the request
        if ($request->user()->id != $word->user_id && !$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        if ($word->image) {
            $filePath = str_replace("storage/", "", $word->image);

            if (Storage::disk("public")->fileExists($filePath)) {
                Storage::disk("public")->delete($filePath);
            }
        }

        $word->delete();

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
