<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordPack extends Model
{
    protected $fillable = [
        "path_id", "name", "description", "type", "visibility", "image"
    ];
}
