<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * 
 *
 * @property mixed $id 6 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 6 occurrences
 * @property int|null $group 6 occurrences
 * @property string|null $last_reviewed_at 6 occurrences
 * @property string|null $review_at 6 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 6 occurrences
 * @property int|null $user_id 6 occurrences
 * @property int|null $word_id 6 occurrences
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Word|null $word
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereGroup($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereLastReviewedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereReviewAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereUserId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserWord whereWordId($value)
 * @mixin \Eloquent
 */
class UserWord extends Model
{
    protected $connection = "mongodb";

    protected $fillable = [
        "user_id", "word_id", "review_at", "last_reviewed_at", "group"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
