<?php

namespace App\Http\Controllers;

use App\Enums\UserSettingType;
use App\Models\UserReview;
use App\Models\UserWord;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function reviewToday(Request $request)
    {
        $user = $request->user();
        $now = now();
        $today = $now->startOfDay();

        // If user has no words he cant count today as reviewed
        if ($user->userWords->count() == 0) {
            abort(400, "You have no words added.");
        }

        // Check if this date hasnt been reviewed already
        if ($user->userReviews()->where("date", $now)->exists()) {
            abort(400, "You already reviewed today.");
        }

        // Check if user has words to review
        if ($user->hasDueWords()) {
            abort(400, "You have words to review! Cheating is not cool.");
        }

        // Check if the user hasnt reached his daily limit yet
        $dailyLimit = $user->userSettings ? $user->userSettings->settings[UserSettingType::DAILY_REVIEWS] : 25;
        if ($user->todayReviews() > $dailyLimit) {
            abort(400, "You have already reached your daily limit!");
        }

        // Mark today as reviewed
        UserReview::insert([
            "user_id" => $user->id,
            "date" => $today,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        return response()->json([
            "message" => "Successfully marked today as reviewed."
        ]);
    }
}
