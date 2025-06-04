<?php

use App\Models\User;
use App\Models\WordPack;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("words", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(WordPack::class)->constrained()->onDelete("cascade");
            $table->string("word");
            $table->string("word_translation");
            $table->string("example");
            $table->string("example_translation");
            $table->string("explanation");
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("words");
    }
};
