<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method bool hasRole(string|array $roles)
 * @method bool hasAnyRole(string|array $roles)
 * @method bool hasAllRoles(string|array $roles)
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Akses ke Filament panel
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }

    /**
     * Role helper: Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Role helper: Petugas
     */
    public function isPetugas(): bool
    {
        return $this->hasRole('petugas');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }
}
