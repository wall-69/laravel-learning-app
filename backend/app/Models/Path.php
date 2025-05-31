<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|Path newModelQuery()
 * @method static Builder<static>|Path newQuery()
 * @method static Builder<static>|Path query()
 * @method static Builder<static>|Path search(string $search)
 * @method static Builder<static>|Path whereCreatedAt($value)
 * @method static Builder<static>|Path whereDescription($value)
 * @method static Builder<static>|Path whereId($value)
 * @method static Builder<static>|Path whereImage($value)
 * @method static Builder<static>|Path whereName($value)
 * @method static Builder<static>|Path whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Path extends Model
{
    protected $connection = "mysql";

    protected $fillable = [
        "name", "description", "image"
    ];

    protected function casts()
    {
        return [
            "created_at" => "datetime:d.m.Y H:i",
            "updated_at" => "datetime:d.m.Y H:i",
        ];
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("name", "LIKE", "%$search%");
    }
}
