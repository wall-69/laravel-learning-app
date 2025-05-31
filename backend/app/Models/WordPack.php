<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int|null $path_id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $visibility
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Word> $words
 * @property-read int|null $words_count
 * @method static \Database\Factories\WordPackFactory factory($count = null, $state = [])
 * @method static Builder<static>|WordPack newModelQuery()
 * @method static Builder<static>|WordPack newQuery()
 * @method static Builder<static>|WordPack query()
 * @method static Builder<static>|WordPack search(string $search)
 * @method static Builder<static>|WordPack whereCreatedAt($value)
 * @method static Builder<static>|WordPack whereDescription($value)
 * @method static Builder<static>|WordPack whereId($value)
 * @method static Builder<static>|WordPack whereImage($value)
 * @method static Builder<static>|WordPack whereName($value)
 * @method static Builder<static>|WordPack wherePathId($value)
 * @method static Builder<static>|WordPack whereType($value)
 * @method static Builder<static>|WordPack whereUpdatedAt($value)
 * @method static Builder<static>|WordPack whereUserId($value)
 * @method static Builder<static>|WordPack whereVisibility($value)
 * @mixin \Eloquent
 */
class WordPack extends Model
{
    use HasFactory;

    protected $connection = "mysql";

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
