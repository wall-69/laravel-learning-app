<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserReview extends Model
{
    protected $connection = "mongodb";

    protected $fillable = [
        "user_id", "date"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
