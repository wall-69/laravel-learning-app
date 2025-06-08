<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $word_pack_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\WordPack $wordPack
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWordPack whereWordPackId($value)
 * @mixin \Eloquent
 */
class UserWordPack extends Model
{
    protected $connection = "mysql";

    protected $fillable = [
        "user_id",
        "word_pack_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wordPack()
    {
        return $this->belongsTo(WordPack::class);
    }
}
