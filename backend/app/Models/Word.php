<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $fillable = [
        "word_pack_id", "word", "word_translation", "example", "example_translation", "explanation", "image"
    ];

    protected function casts()
    {
        return [
            "created_at" => "datetime:d.m.Y H:i",
            "updated_at" => "datetime:d.m.Y H:i",
        ];
    }

    public function wordPack()
    {
        return $this->belongsTo(WordPack::class);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("word", "LIKE", "%$search%");
    }
}
