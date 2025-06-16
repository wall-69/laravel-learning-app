<?php

namespace App\Http\Controllers;

use App\Models\UserWord;
use App\Models\WordPack;
use Gate;
use Illuminate\Http\Request;

class UserWordController extends Controller
{
    /**
     * GET function returning users words paginator object.
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $search = $request->search ?? "";

        $paginator = $user->userWords()
            ->whereHas("word", function ($q) use ($search) {
                $q->search($search);
            })
            ->latest()->with("word")->paginate(30);

        return response()->json($paginator);
    }

    /**
     * GET function returning response with due words for today (as *due_words*) in an array
     */
    public function due(Request $request)
    {
        $user = $request->user();

        $dueWords = $user->userWords()->where("review_at", "<", now())->with("word")->get();

        return response()->json([
            "due_words" => $dueWords
        ]);
    }

    /**
     * POST function setting the word as being correctly guessed.
     */
    public function correct(Request $request, UserWord $userWord)
    {
        Gate::authorize("update", $userWord);

        $toUpdate = [];

        // Get the amount of days to space
        $days = 1;
        if ($userWord->group > 1) {
            $days = 2 ** ($userWord->group - 1);
        }

        // Update review_at and last_reviewed_at
        $toUpdate["review_at"] = now()->addDays($days)->startOfDay();
        $toUpdate["last_reviewed_at"] = now();

        // Update group
        if ($userWord->group < 10) {
            $toUpdate["group"] = $userWord->group + 1;
        }

        // Update model
        $userWord->update($toUpdate);

        return response()->json([
            "message" => "UserWord next review_at and group updated successfully."
        ]);
    }

    public function destroy(Request $request, UserWord $userWord)
    {
        Gate::authorize("destroy", $userWord);

        // Temp data
        $word = $userWord->word;
        $userId = $word->user_id;

        // Delete the UserWord
        $userWord->delete();

        // If this UserWord is created by a user and not an admin we
        // check if this Word is used by any other user, if not then we delete it 
        if ($userId && !UserWord::whereWordId($word->id)->exists()) {
            $word->delete();
        }

        return response()->json([
            "message" => "UserWord deleted.",
            "notifications" => [
                "success" => ["The word was successfully deleted."]
            ]
        ]);
    }

    public function revisitWordPack(Request $request, WordPack $wordPack)
    {
        $user = $request->user();

        $wordIds = $wordPack->words->pluck("id");
        $revisitWords = $user->userWords()->whereIn("word_id", $wordIds)->with("word")->get();
        $revisitWords->each(function ($userWord) {
            $userWord->group = 1;
        });

        return response()->json([
            "revisit_words" => $revisitWords
        ]);
    }
}
