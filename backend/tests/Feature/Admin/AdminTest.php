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

class AdminTest extends TestCase
{
    use RefreshDatabase;
    use UserHelper;

    public function test_admin_can_add_a_user()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $data = [
            "name" => "dummy",
            "surname" => "dummy",
            "email" => "dummy@mail.net",
            "password" => "dummypass",
            "password_confirmation" => "dummypass",
        ];
        $response = $this->postJson(route("users.store"), $data);

        $response->assertSuccessful();
    }

    public function test_admin_can_add_a_word()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $wordPack = WordPack::factory()->create([
            "user_id" => $admin->id,
            "type" => WordPackType::OFFICIAL
        ]);

        $data = [
            "word_pack_id" => $wordPack->id,
            "word" => fake()->sentence(),
            "word_translation" => fake()->sentence(),
            "example" => fake()->sentence(),
            "example_translation" => fake()->sentence(),
            "explanation" => fake()->sentence(),
        ];
        $response = $this->postJson(route("words.store"), $data);

        $response->assertSuccessful();
    }

    public function test_admin_can_add_an_official_word_pack()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $data = [
            "name" => fake()->sentence(3),
            "description" => fake()->sentence(),
            "type" => WordPackType::OFFICIAL,
            "visibility" => WordPackVisibility::PUBLIC,
        ];
        $response = $this->postJson(route("word-packs.store"), $data);

        $response->assertSuccessful();
    }

    public function test_admin_can_create_a_path()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $data = [
            "name" => fake()->sentence(3),
            "description" => fake()->sentence()
        ];
        $response = $this->postJson(route("paths.store"), $data);

        $response->assertSuccessful();
    }

    public function test_admin_can_add_an_admin()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $user = $this->createUser();
        $data = [
            "user_id" => $user->id
        ];
        $response = $this->postJson(route("admins.store"), $data);

        $response->assertSuccessful();
    }

    public function test_admin_cannot_add_user_as_admin_if_already_admin()
    {
        $admin = $this->createUserAsAdmin();

        $this->actingAs($admin);

        $secondAdmin = $this->createUserAsAdmin();
        $data = [
            "user_id" => $secondAdmin->id
        ];
        $response = $this->postJson(route("admins.store"), $data);

        $response->assertUnprocessable();
    }
}
