<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_USER = 'user';

    /**
     * Roles allowed into the admin dashboard.
     *
     * @var list<string>
     */
    public const STAFF_ROLES = [self::ROLE_ADMIN, self::ROLE_MANAGER];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'bio', 'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->type === self::ROLE_ADMIN;
    }

    public function isManager(): bool
    {
        return $this->type === self::ROLE_MANAGER;
    }

    /**
     * May the user access the admin dashboard at all?
     */
    public function isStaff(): bool
    {
        return in_array($this->type, self::STAFF_ROLES, true);
    }
}
