<?php

namespace App\Http\Controllers;

use App\Models\UserWord;
use Illuminate\Http\Request;

class UserWordController extends Controller
{
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

    public function correct(Request $request, UserWord $userWord)
    {
        if ($userWord->user_id != $request->user()->id) {
            abort(403, "You can't do this.");
        }

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
}
