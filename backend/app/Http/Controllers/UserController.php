<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserSetting;
use Gate;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $data = $user->load(["userReviews", "userWordPacks", "userSettings"]);

        // If no UserSettings are set we provide empty model
        $data->setRelation('userSettings', $data->userSettings ?? new UserSetting());

        // Attributes for frontend :D
        $data->setAttribute("hasWords", boolval($user->words));
        $data->setAttribute("hasDueWords", $user->hasDueWords());

        return response()->json([
            "user" => $data
        ]);
    }

    public function userById(User $user)
    {
        return response()->json($user);
    }

    public function index(Request $request)
    {
        $paginator = User::search($request->search ?? "")->latest()->paginate(30);
        $data = $paginator->makeHidden("admin");
        $paginator->data = $data;

        return response()->json($paginator);
    }

    public function store(Request $request)
    {
        // Only let guests and admins create new users
        if ($request->user() && !$request->user()->admin) {
            abort(403, "You can't do this.");
        }

        $data = $request->validate([
            "name" => "required|string",
            "surname" => "required|string",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
            "tos" => "sometimes|accepted"
        ]);

        $user = User::create($data);

        return response()->json([
            "message" => "User was successfully created.",
            "notifications" => [
                "success" => [
                    $request->user() && $request->user()->admin ? "The user was successfully created!" : "Your account was successfully created!"
                ]
            ]
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize("update", $user);

        $data = $request->validate([
            "name" => "sometimes|required|string",
            "surname" => "sometimes|required|string",
            "email" => "sometimes|required|email",
            "new_password" => "sometimes|required|min:6",
        ]);

        // Encrypt the new password
        if ($request->has("new_password")) {
            $data["password"] = Hash::make($request->new_password);
        }

        $user->update($data);

        return response()->json([
            "message" => "User was successfully updated.",
            "notifications" => [
                "success" => [
                    $request->user()->admin ? "The user was successfully updated!" : "Your details were updated!"
                ]
            ]
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        Gate::authorize("delete", $user);

        // Logout the user, if it is not an admin deleting the user
        if (!$request->user()->admin) {
            $request->validate([
                "password" => "required"
            ]);

            // Check if current password is correct
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    "password" => ["Invalid credentials."]
                ]);
            }

            auth("web")->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();

        return response()->json([
            "message" => "User was successfully deleted.",
            "notifications" => [
                "success" => [
                    $request->user()->admin ? "The user was successfully deleted!" : "Your account was successfully deleted!"
                ]
            ]
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                "email" => __($status)
            ]);
        }

        return response()->json([
            "message" => "Email successfully sent.",
            "notifications" => [
                "success" => [
                    "Reset email was successfully sent!"
                ]
            ]
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => "required|confirmed|min:6",
        ]);

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                // Update the password with new one
                $user->update([
                    "password" => Hash::make($password)
                ]);

                // Change remember token to invalidate old session stuff
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                "password_confirmation" => __($status)
            ]);
        }

        return response()->json([
            "message" => "Password successfully reset.",
            "notifications" => [
                "success" => [
                    "Your password was changed. You can now log in."
                ]
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "password" => "required",
            "new_password" => "required|confirmed|min:6"
        ]);

        $user = $request->user();

        // Check if current password is correct
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "password" => ["Invalid credentials."]
            ]);
        }

        // Hash new password
        $user->update([
            "password" => Hash::make($request->new_password)
        ]);

        return response()->json([
            "message" => "Password successfully changed.",
            "notifications" => [
                "success" => [
                    "Your password was changed."
                ]
            ]
        ]);
    }
}
