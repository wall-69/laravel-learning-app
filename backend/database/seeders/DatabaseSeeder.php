<?php

namespace Database\Seeders;

use App\Enums\WordPackType;
use App\Enums\WordPackVisibility;
use App\Models\Admin;
use App\Models\User;
use App\Models\Word;
use App\Models\WordPack;
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

        // Create users
        User::factory(100)->create();

        // Temp words

        $wordPack = WordPack::factory()->create([
            "user_id" => $admin->id,
            "name" => "Beginner - verbs #1",
            "description" => "Word pack containing verbs for beginners who want to start with english.",
            "type" => WordPackType::OFFICIAL,
            "visibility" => WordPackVisibility::PUBLIC,
            "image" => null
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to help',
            'word_translation' => 'pomôcť (niekomu, s niečím)',
            'example' => 'Do you need help?',
            'example_translation' => 'Potrebuješ pomôcť?',
            'explanation' => 'to make it possible or easier for someone to do something, by doing part of the work yourself or by providing advice, money, support, etc.',
            'image' => 'storage/img/words/vJ6VTc7OyhD2hLMhyNWOVt3K9BWb7WhsMlljvD5O.jpg',
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to see',
            'word_translation' => 'vidieť (niečo, niekoho)',
            'example' => 'Do you see that?',
            'example_translation' => 'Vidíš tam to?',
            'explanation' => 'to use eyes to notice something',
            'image' => null,
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to run',
            'word_translation' => 'utekať, utiecť',
            'example' => 'He runs faster than anyone else on the team.',
            'example_translation' => 'Uteká rýchlejšie ako ktokoľvek iný v tíme.',
            'explanation' => 'to move fast by foot',
            'image' => 'storage/img/words/4fjmuZpuHN4qnvyr1znxvfFAwga4rosgldvKQYL3.jpg',
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to eat',
            'word_translation' => 'jesť, zjesť',
            'example' => 'He eats a lot, that\'s why he weighs so much!',
            'example_translation' => 'Je veľa, preto toľko váži!',
            'explanation' => 'to put food in the mouth and swallow',
            'image' => 'storage/img/words/aqjqyV8kxWeEw4oSO1Nb0JVPEWByGJGICkSM6xJY.jpg',
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to drink',
            'word_translation' => 'piť',
            'example' => 'He drank it all.',
            'example_translation' => 'Vypil to všetko.',
            'explanation' => 'to take liquid into the mouth and swallow',
            'image' => 'storage/img/words/4nR8asdQvZpsYOoZ0BncpgIENilqutCPzBrJrKIG.png',
        ]);

        Word::factory()->create([
            'word_pack_id' => $wordPack->id,
            'word' => 'to say',
            'word_translation' => 'povedať (niečo)',
            'example' => 'She says she didn\'t do it.',
            'example_translation' => 'Hovorí, že to neurobila.',
            'explanation' => 'to speak words',
            'image' => null,
        ]);
    }
}
