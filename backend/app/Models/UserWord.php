<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserWord extends Model
{
    protected $connection = "mongodb";

    protected $fillable = [
        "user_id", "word_id", "next_review"
    ];
}
