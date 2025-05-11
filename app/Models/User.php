<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Eloquent implements AuthenticatableContract
{
    use HasApiTokens, Notifiable, Authenticatable;

    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'tanggal_lahir',
        'telepon',
        'alamat',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];
}
