<?php

namespace Tests\Feature\Admin;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\Admin;
use App\Models\User;
use App\Models\WordPack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class UserRestrictionsTest extends TestCase
{
    use RefreshDatabase;
    use UserHelper;

    public function test_user_cannot_create_an_official_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $data = [
            "name" => fake()->sentence(3),
            "description" => fake()->sentence(),
            "type" => WordPackType::OFFICIAL,
            "visibility" => WordPackVisibility::PUBLIC,
        ];
        $response = $this->postJson(route("word-packs.store"), $data);

        $response->assertForbidden();
    }

    public function test_user_cannot_create_a_path()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $data = [
            "name" => fake()->sentence(3),
            "description" => fake()->sentence()
        ];
        $response = $this->postJson(route("paths.store"), $data);

        $response->assertForbidden();
    }

    public function test_user_cannot_add_an_admin()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $secondUser = $this->createUser();
        $data = [
            "user_id" => $secondUser->id
        ];
        $response = $this->postJson(route("admins.store"), $data);

        $response->assertForbidden();
    }
}
