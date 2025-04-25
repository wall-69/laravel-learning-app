<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserWord extends Model
{
    protected $connection = "mongodb";

    protected $fillable = [
        "user_id", "word_id", "review_at", "group"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
