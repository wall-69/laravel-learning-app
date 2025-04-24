<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserWordController extends Controller
{
    public function due(Request $request)
    {
        $user = $request->user();

        $userWords = $user->userWords;

        $dueWords = [];
        foreach ($userWords as $userWord) {
            $dueWords[] = $userWord->word;
        }

        return response()->json([
            "due_words" => $dueWords
        ]);
    }
}
