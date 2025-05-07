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

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("name", "LIKE", "%$search%")->orWhere("surname", "LIKE", "%$search%");
    }

    // Functions
    public function hasDueWords()
    {
        return $this->userWords()->where("review_at", "<", now())->exists();
    }

    // Password reset
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }
}
