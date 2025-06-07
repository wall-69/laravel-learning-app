<?php

namespace Database\Factories;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WordPack>
 */
class WordPackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "path_id" => null,
            "user_id" => null,
            "name" => fake()->sentence(3),
            "description" => fake()->sentence(),
            "type" => WordPackType::COMMUNITY,
            "visibility" => WordPackVisibility::PUBLIC,
            "image" => null
        ];
    }
}
