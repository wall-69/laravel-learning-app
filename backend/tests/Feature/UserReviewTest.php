<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_dont_mark_today_as_reviewed_when_user_has_no_words()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route("user-reviews.review-today"));

        $response->assertBadRequest();
        $response->assertSee("You have no words added.");
    }
}
