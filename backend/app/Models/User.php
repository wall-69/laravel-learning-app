<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        "is_admin"
    ];

    protected $hidden = [
        "password",
        "remember_token",
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
}
