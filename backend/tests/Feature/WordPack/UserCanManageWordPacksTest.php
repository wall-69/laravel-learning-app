<?php

namespace Tests\Feature\WordPack;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\WordPack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\UserHelper;
use Tests\TestCase;

class UserCanManageWordPacksTest extends TestCase
{
    use RefreshDatabase;
    use UserHelper;

    public function test_user_can_index_word_packs()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->getJson(route("word-packs.index"));

        $response->assertSuccessful();
    }

    public function test_user_can_add_a_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $data = [
            "name" => fake()->sentence(3),
            "description" => fake()->sentence(),
            "type" => WordPackType::COMMUNITY,
            "visibility" => WordPackVisibility::PUBLIC,
        ];
        $response = $this->postJson(route("word-packs.store"), $data);

        $response->assertSuccessful();
    }

    public function test_user_can_update_his_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $wordPack = WordPack::factory()->create([
            "user_id" => $user->id
        ]);
        $data = [
            "name" => fake()->sentence(3),
            "description" => $wordPack->description,
            "visibility" => $wordPack->visibility
        ];
        $response = $this->patchJson(route("word-packs.update", $wordPack->id), $data);

        $response->assertSuccessful();
    }

    public function test_user_cannot_update_another_users_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $wordPack = WordPack::factory()->create([
            "user_id" => 15
        ]);
        $data = [
            "name" => fake()->sentence(3),
            "description" => $wordPack->description,
            "visibility" => $wordPack->visibility
        ];
        $response = $this->patchJson(route("word-packs.update", $wordPack->id), $data);

        $response->assertForbidden();
    }

    public function test_user_can_delete_his_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $wordPack = WordPack::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->deleteJson(route("word-packs.destroy", $wordPack->id));

        $response->assertSuccessful();
    }

    public function test_user_cannot_delete_another_users_word_pack()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $wordPack = WordPack::factory()->create([
            "user_id" => 15
        ]);
        $response = $this->deleteJson(route("word-packs.destroy", $wordPack->id));

        $response->assertForbidden();
    }
}
