<?php

namespace App\Http\Controllers;

use App\Models\UserWord;
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

        // Update review_at
        $toUpdate["review_at"] = now()->addDays($days)->startOfDay();

        // Update group
        if ($userWord->group < 10) {
            $toUpdate["group"] = $userWord->group + 1;
        }

        // Update model
        UserWord::where("id", $userWord->id)->first()->update($toUpdate);

        return response()->json([
            "message" => "UserWord next review_at and group updated successfully."
        ]);
    }

    public function destroy(Request $request, UserWord $userWord)
    {
        Gate::authorize("destroy", $userWord);

        $userWord->delete();

        return response()->json([
            "message" => "UserWord deleted.",
            "notifications" => [
                "success" => ["The word was successfully deleted."]
            ]
        ]);
    }
}
