<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\HybridRelations;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserReview> $userReviews
 * @property-read int|null $user_reviews_count
 * @property-read \App\Models\UserSetting|null $userSettings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWordPack> $userWordPacks
 * @property-read int|null $user_word_packs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWord> $userWords
 * @property-read int|null $user_words_count
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User newModelQuery()
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User newQuery()
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User query()
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User search(string $search)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereEmail($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereEmailVerifiedAt($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereId($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereName($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User wherePassword($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereRememberToken($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereSurname($value)
 * @method static \MongoDB\Laravel\Helpers\EloquentBuilder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    use HybridRelations;

    protected $connection = "mysql";

    protected $fillable = [
        "name",
        "surname",
        "email",
        "password",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected $with = [
        "admin"
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime:d.m.Y H:i",
            "created_at" => "datetime:d.m.Y H:i",
            "updated_at" => "datetime:d.m.Y H:i",
            "password" => "hashed",
        ];
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function wordPacks()
    {
        return $this->hasMany(WordPack::class);
    }

    public function userReviews()
    {
        return $this->hasMany(UserReview::class, "user_id", "id");
    }

    public function userWords()
    {
        return $this->hasMany(UserWord::class, "user_id", "id");
    }

    public function userWordPacks()
    {
        return $this->hasMany(UserWordPack::class);
    }

    public function userSettings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("name", "LIKE", "%$search%")->orWhere("surname", "LIKE", "%$search%");
    }

    // Functions
    public function hasDueWords()
    {
        return $this->userWords()->where("review_at", "<", now())->exists();
    }

    public function todayReviews()
    {
        return $this->userWords()->where("last_reviewed_at", ">", now()->startOfDay())->count();
    }

    // Password reset
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }
}
