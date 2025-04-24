<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWordPack extends Model
{
    protected $connection = "mysql";

    protected $fillable = [
        "user_id", "word_pack_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wordPack()
    {
        return $this->belongsTo(WordPack::class);
    }
}
