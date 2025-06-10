<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $word_pack_id
 * @property string $word
 * @property string $word_translation
 * @property string $example
 * @property string $example_translation
 * @property string $explanation
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WordPack $wordPack
 * @method static \Database\Factories\WordFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word search(string $search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereExampleTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereExplanation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWordPackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWordTranslation($value)
 * @mixin \Eloquent
 */
class Word extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $fillable = [
        "user_id",
        "word_pack_id",
        "word",
        "word_translation",
        "example",
        "example_translation",
        "explanation",
        "image"
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
