<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordPack extends Model
{
    protected $fillable = [
        "name", "type", "visibility", "image"
    ];
}
