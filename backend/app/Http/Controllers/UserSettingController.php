<?php

namespace App\Http\Controllers;

use App\Enums\UserSettingType;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserSettingController extends Controller
{
    public function set(Request $request)
    {
        $validSettings = array_map(fn ($case) => $case->value, UserSettingType::cases());

        $request->validate([
            "setting" => ["required", "string", Rule::in($validSettings)],
            "value" => "required"
        ]);

        $user = $request->user();
        $userSettings = $user->userSettings;

        // Create settings for the user if he doesnt have them
        if (!$userSettings) {
            $userSettings = UserSetting::create([
                "user_id" => $user->id,
                "settings" => null
            ]);
        } else if (now()->startOfDay() == $userSettings->updated_at->startOfDay()) {
            throw ValidationException::withMessages([
                "setting" => "You can change this setting only once per day!"
            ]);
        }

        $userSettings->set($request->setting, $request->value);

        return response()->json([
            "message" => "User setting $request->setting successfully set to $request->value!",
            "notifications" => [
                "sucess" => [
                    "Setting was changed successfully!"
                ]
            ]
        ]);
    }
}
