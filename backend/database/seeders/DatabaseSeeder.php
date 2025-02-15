<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        $admin = User::factory()->create([
            "name" => "John",
            "surname" => "Doe",
            "email" => "john@doe.com",
            "password" => Hash::make("doedoe")
        ]);

        Admin::factory()->create([
            "user_id" => $admin->id
        ]);
    }
}
