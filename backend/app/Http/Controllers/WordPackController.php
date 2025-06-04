<?php

namespace App\Http\Controllers;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\UserWord;
use App\Models\UserWordPack;
use App\Models\WordPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WordPackController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json($user->wordPacks);
    }

    public function wordPackById(WordPack $wordPack)
    {
        return response()->json($wordPack);
    }

    public function wordPackWithWordsById(WordPack $wordPack)
    {
        return response()->json($wordPack->load("words"));
    }

    public function index(Request $request)
    {
        $paginator = WordPack::where(function ($query) use ($request) {
            if ($request->has("visibility")) {
                $query->whereVisibility($request->visibility);
            }
        })->search($request->search ?? "")->latest()->paginate(30);

        return response()->json($paginator);
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
            "image" => "nullable"
        ]);

        // Null path_id
        $data["path_id"] = $data["path_id"] ?? null;

        // Save image
        if ($request->hasFile("image") || $request->image == null) {
            // Delete old image, if one is set
            if ($wordPack->image) {
                $filePath = str_replace("storage/", "", $wordPack->image);

                if (Storage::disk("public")->fileExists($filePath)) {
                    Storage::disk("public")->delete($filePath);
                }
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

        // Remove the image
        if ($wordPack->image) {
            $filePath = str_replace("storage/", "", $wordPack->image);

            if (Storage::disk("public")->fileExists($filePath)) {
                Storage::disk("public")->delete($filePath);
            }
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

    public function addToUser(Request $request, WordPack $wordPack)
    {
        $request->validate([
            "except_words" => "present|array"
        ]);

        $user = $request->user();
        $exceptWords = $request->except_words;

        // Dont add this WordPack, if user has already added it
        if (UserWordPack::where("user_id", $user->id)->where("word_pack_id", $wordPack->id)->exists()) {
            abort(400, "You already have this WordPack added.");
        }

        // Add this WordPack to users WordPacks
        UserWordPack::create([
            "user_id" => $user->id,
            "word_pack_id" => $wordPack->id
        ]);

        // Fetches all word_ids the user already has from MongoDB UserWord that are part of this word pack.
        $existingWordIds = UserWord::where("user_id", $user->id)
            ->whereIn("word_id", $wordPack->words->pluck("id"))
            ->pluck("word_id")
            ->toArray();

        // Filters out word_ids that the user already has added and the ones the user doesnt want to add
        $wordsToAdd = $wordPack->words->filter(fn($word) => !in_array($word->id, $existingWordIds) && !in_array($word->id, $exceptWords));

        // Create array data to be inserted
        $now = now();
        $insertData = $wordsToAdd->values()->map(function ($word) use ($user, $now) {
            return [
                "user_id" => $user->id,
                "word_id" => $word->id,
                "group" => 1,
                "review_at" => $now,
                "last_reviewed_at" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ];
        })->all();

        // Insert the data, if there are any
        if (!empty($insertData)) {
            UserWord::insert($insertData);
        }

        return response()->json([
            "message" => "Successfully added WordPack to user.",
            "user_word_packs" => $user->userWordPacks
        ]);
    }

    public function updateForUser(Request $request, WordPack $wordPack)
    {
        $request->validate([
            "except_words" => "present|array"
        ]);

        $user = $request->user();
        $exceptWords = $request->except_words;

        // Dont update this WordPack, if user hasnt added it
        if (!UserWordPack::where("user_id", $user->id)->where("word_pack_id", $wordPack->id)->exists()) {
            abort(400, "You dont have this WordPack added.");
        }

        // Fetches all word_ids the user already has from MongoDB UserWord that are part of this word pack.
        $existingWordIds = $user->userWords()
            ->whereIn("word_id", $wordPack->words->pluck("id"))
            ->pluck("word_id")
            ->toArray();

        // Filters out word_ids that the user already has added and the ones the user doesnt want to add
        $wordsToAdd = $wordPack->words->filter(fn($word) => !in_array($word->id, $existingWordIds) && !in_array($word->id, $exceptWords));

        // Create array data to be inserted
        $now = now();
        $insertData = $wordsToAdd->values()->map(function ($word) use ($user, $now) {
            return [
                "user_id" => $user->id,
                "word_id" => $word->id,
                "group" => 1,
                "review_at" => $now,
                "last_reviewed_at" => null,
                "created_at" => $now,
                "updated_at" => $now,
            ];
        })->all();

        // Insert the data, if there are any
        if (!empty($insertData)) {
            UserWord::insert($insertData);
        }

        return response()->json([
            "message" => "Successfully updated WordPack for user.",
            "user_word_packs" => $user->userWordPacks
        ]);
    }

    public function removeFromUser(Request $request, WordPack $wordPack)
    {
        $user = $request->user();

        // If the user doesnt have this wordpack, we cant remove it :D
        if (!UserWordPack::where("user_id", $user->id)->where("word_pack_id", $wordPack->id)->exists()) {
            abort(400, "You don't have this WordPack added.");
        }

        // Delete UserWords from this WordPack
        $user->userWords()
            ->whereIn("word_id", $wordPack->words->pluck("id"))
            ->delete();

        // Delete UserWordPack
        $userWordPack = UserWordPack::where("user_id", $user->id)->where("word_pack_id", $wordPack->id);
        $userWordPack->delete();

        return response()->json([
            "message" => "Successfully removed WordPack from user.",
            "user_word_packs" => $user->userWordPacks
        ]);
    }
}
