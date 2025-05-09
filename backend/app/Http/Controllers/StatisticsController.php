<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();

        // Get the review dates (returns Carbon object)
        $reviewDates = $user->userReviews()->pluck("date")->toArray();
        // Create associative array from the dates, then flip it (because array_map creates indexed assoc array with the dates as values, but we
        // want them as keys for lookup later)
        $dateSet = array_flip(array_map(fn ($date) => $date->toDateString(), $reviewDates));

        // Streak
        $streak = 0;
        $day = now()->startOfDay()->subDay();

        // Check today
        if (isset($dateSet[now()->startOfDay()->toDateString()])) {
            $streak++;
        }

        // Start checking from yesterday until date on which the user did not review
        while (isset($dateSet[$day->toDateString()])) {
            $streak++;
            $day->subDay();
        }

        return response()->json([
            "streak" => $streak,
            "words" => $user->userWords->count(),
            "word_packs" => $user->userWordPacks->count(),
            "paths" => -1
        ]);
    }
}
