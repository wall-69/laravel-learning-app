<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use UserHelper;

    public function test_guest_can_register_with_valid_data()
    {
        // Valid data for registration
        $data = [
            "name" => "Paul",
            "surname" => "Doe",
            "email" => fake()->email(),
            "password" => "password",
            "password_confirmation" => "password",
            "tos" => true
        ];

        // Post request expecting JSON response
        $response = $this->postJson(route("users.store"), $data);

        // Assert that the request was successful (user was registered => created)
        $response->assertSuccessful();

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_guest_cannot_register_with_invalid_data()
    {
        // Invalid data for registration
        $data = [
            "name" => "Paul",
            "surname" => "Doe",
            "email" => fake()->email(),
            "password" => "password",
            "password_confirmation" => "password",
            "tos" => false
        ];

        // Post request expecting JSON response
        $response = $this->postjson(route("users.store"), $data);


        // Assert that the request was aborted (validation error)
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["tos"]);

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_user_cannot_register()
    {
        // Act as a logged in user
        $user = $this->createUser();;
        $this->actingAs($user);

        $data = [
            "name" => "Paul",
            "surname" => "Doe",
            "email" => fake()->email(),
            "password" => "password",
            "password_confirmation" => "password",
            "tos" => true
        ];

        $response = $this->postJson(route("users.store"), $data);

        $response->assertForbidden();
    }
}
