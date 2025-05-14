<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserWord;
use Illuminate\Auth\Access\Response;

class UserWordPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, UserWord $userWord)
    {
        // Cancel the request, if this is not the users word
        if ($user->id != $userWord->user_id) {
            return Response::deny("You can't do this.");
        }

        return Response::allow();
    }

    public function destroy(User $user, UserWord $userWord)
    {
        // Cancel the request, if this is not the users word
        if ($user->id != $userWord->user_id) {
            return Response::deny("You can't do this.");
        }

        return Response::allow();
    }
}
