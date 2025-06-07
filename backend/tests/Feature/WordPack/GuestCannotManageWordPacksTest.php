<?php

namespace Tests\Feature\WordPack;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestCannotManageWordPacksTest extends TestCase
{
    public function test_guest_cannot_access_word_pack_routes()
    {
        $routes = [
            ["method" => "getJson", "uri" => route("word-packs.index")],
            ["method" => "postJson", "uri" => route("word-packs.store")],
            ["method" => "patchJson", "uri" => route("word-packs.update", 1)],
            ["method" => "deleteJson", "uri" => route("word-packs.destroy", 1)],
        ];

        foreach ($routes as ["method" => $method, "uri" => $uri]) {
            $response = $this->$method($uri);

            $response->assertUnauthorized();
        }
    }
}
