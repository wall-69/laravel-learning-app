<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, User $updatedUser)
    {
        // If the User that is being updated is not the user himself or an admin, cancel the request
        if ($user->id != $updatedUser->id && !$user->admin) {
            return Response::deny("You can't do this.");
        }

        return Response::allow();
    }

    public function delete(User $user, User $deletedUser)
    {
        // If the User that is being deleted is not the user himself or an admin, cancel the request
        if ($user->id != $deletedUser->id && !$user->admin) {
            return Response::deny("You can't do this.");
        }

        return Response::allow();
    }
}
