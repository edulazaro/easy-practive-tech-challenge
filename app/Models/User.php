<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /** @var array<string> The attributes that are mass assignable. */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /** @var array<string> The attributes that should be hidden for arrays. */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** @var array<string> The attributes that should be cast to native types. */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
