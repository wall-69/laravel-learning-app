<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordPack extends Model
{
    use HasFactory;

    protected $fillable = [
        "path_id", "user_id", "name", "description", "type", "visibility", "image"
    ];

    protected function casts()
    {
        return [
            "created_at" => "datetime:d.m.Y H:i",
            "updated_at" => "datetime:d.m.Y H:i",
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("name", "LIKE", "%$search%");
    }
}
