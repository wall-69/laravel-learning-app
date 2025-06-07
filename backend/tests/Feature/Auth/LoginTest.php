<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use UserHelper;

    public function test_guest_can_login_with_valid_data()
    {
        $user = User::factory()->create();

        // Valid data for login
        $data = [
            "email" => $user->email,
            "password" => "password",
        ];

        // Post request expecting JSON response
        $response = $this->postJson(route("auth.login"), $data);

        // Assert that the request was successful
        $response->assertSuccessful();

        // Assert that the user is logged in
        $this->assertAuthenticated();
    }

    public function test_guest_cannot_login_with_invalid_data()
    {
        $user = $this->createUser();

        // Valid data for login
        $data = [
            "email" => $user->email,
            "password" => "passw",
        ];

        // Post request expecting JSON response
        $response = $this->postJson(route("auth.login"), $data);

        // Assert that the request was aborted (validation error)
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["password"]);

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_user_cannot_login()
    {
        // Act as a logged in user
        $user = $this->createUser();
        $this->actingAs($user);

        $data = [
            "email" => $user->email,
            "password" => "password",
        ];

        $response = $this->postJson(route("auth.login"), $data);

        $response->assertForbidden();
    }
}
