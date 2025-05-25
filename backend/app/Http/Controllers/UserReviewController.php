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

        // Check if this date hasnt been reviewed already
        if ($user->userReviews()->where("date", $now)->exists()) {
            abort(400, "You already reviewed today.");
        }

        // Check if user has words to review and he hasnt reach his daily limit yet
        $dailyLimit = $user->userSettings ? $user->userSettings->settings[UserSettingType::DAILY_REVIEWS] : 25;
        if ($user->hasDueWords() && $user->todayReviews() < $dailyLimit) {
            abort(400, "You have words to review! Cheating is not cool.");
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
