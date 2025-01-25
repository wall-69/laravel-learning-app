<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Request;
use Session;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_can_register_with_valid_data()
    {
        // Valid data for registration
        $data = [
            "name" => "Paul",
            "surname" => "Doe",
            "email" => "paul@doe.com",
            "password" => "password",
            "password_confirmation" => "password",
            "tos" => true
        ];

        // Post request expecting JSON response
        $response = $this->postjson(route("users.store"), $data);

        // Assert that the request was successful (user was registered => created)
        $response->assertSuccessful();

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_guest_cant_register_with_invalid_data()
    {
        // Invalid data for registration
        $data = [
            "name" => "Paul",
            "surname" => "Doe",
            "email" => "paul@doe.com",
            "password" => "password",
            "password_confirmation" => "password",
            "tos" => false
        ];

        // Post request expecting JSON response
        $response = $this->postjson(route("users.store"), $data);


        // Assert that the request was aborted (validation error)
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_guest_can_login_with_valid_data()
    {
        $user = User::factory()->create();

        // Valid data for login
        $data = [
            "email" => $user->email,
            "password" => "password",
        ];

        // Post request expecting JSON response
        $response = $this->postJson(route("users.authenticate"), $data);

        // Assert that the request was successful and returned the user object
        $response->assertSuccessful();
        $response->assertJsonStructure([
            "user"
        ]);

        // Assert that the user is logged in
        $this->assertAuthenticated();
    }

    public function test_guest_cant_login_with_invalid_data()
    {
        $user = User::factory()->create();

        // Valid data for login
        $data = [
            "email" => $user->email,
            "password" => "passw",
        ];

        // Post request expecting JSON response
        $response = $this->postJson(route("users.authenticate"), $data);

        // Assert that the request was aborted (validation error)
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            "errors"
        ]);

        // Assert that the user is not logged in
        $this->assertGuest();
    }
}
