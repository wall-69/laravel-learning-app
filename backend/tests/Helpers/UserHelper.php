<?php

namespace Tests\Helpers;

use App\Models\Admin;
use App\Models\User;

trait UserHelper
{
    protected function createUser(): User
    {
        return User::factory()->create();
    }

    protected function createUserAsAdmin(): User
    {
        $user = User::factory()->create();

        Admin::factory()->create([
            "user_id" => $user->id
        ]);

        return $user;
    }
}
