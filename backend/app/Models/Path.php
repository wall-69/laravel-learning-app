<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    protected $fillable = [
        "name", "description", "image"
    ];
}
