<?php

use App\Models\Path;
use App\Models\User;
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
        Schema::create("word_packs", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Path::class)->nullable()->onDelete("set null");
            $table->foreignIdFor(User::class);
            $table->string("name");
            $table->string("description");
            $table->enum("type", ["official", "community"]);
            $table->enum("visibility", ["public", "private"]);
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("word_packs");
    }
};
