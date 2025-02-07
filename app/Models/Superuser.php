<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Superuser extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'role',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed'
    ];
}
