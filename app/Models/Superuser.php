<?php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Superuser extends Authenticatable implements FilamentUser
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
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isModerator()
    {
        return $this->role == 'moderator';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@admin.com');
    }
}
