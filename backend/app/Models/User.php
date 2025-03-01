<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("name", "LIKE", "%$search%")->orWhere("surname", "LIKE", "%$search%");
    }
}
