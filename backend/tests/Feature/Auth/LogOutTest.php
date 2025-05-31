<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogOutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cant_log_out()
    {
        // Post request expecting JSON response
        $response = $this->postJson(route("auth.logout"));

        // Assert that the request was aborted (not logged in)
        $response->assertUnauthorized();

        // Assert that the user is not logged in
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        // Act as a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Post request expecting JSON response
        $response = $this->postJson(route("auth.logout"));

        // Assert that the request was successful
        $response->assertSuccessful();

        // Assert that the user is not logged in
        $this->assertGuest("web");
    }
}
