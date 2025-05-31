<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * 
 *
 * @property mixed $id 1 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 1 occurrences
 * @property string|null $date 1 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 1 occurrences
 * @property int|null $user_id 1 occurrences
 * @property-read \App\Models\User|null $user
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview aggregate($function = null, $columns = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview whereDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|UserReview whereUserId($value)
 * @mixin \Eloquent
 */
class UserReview extends Model
{
    protected $connection = "mongodb";

    protected $fillable = [
        "user_id", "date"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
