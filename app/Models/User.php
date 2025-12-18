<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'integer',
        'is_active' => 'integer',
    ];

    /**
     * Get role name
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            1 => 'Teller',
            2 => 'Manajer',
            3 => 'Nasabah',
        ];

        return $roles[$this->role] ?? 'Unknown';
    }

    /**
     * Check if user is teller
     */
    public function isTeller()
    {
        return $this->role === 1;
    }

    /**
     * Check if user is manajer
     */
    public function isManajer()
    {
        return $this->role === 2;
    }

    /**
     * Check if user is nasabah
     */
    public function isNasabah()
    {
        return $this->role === 3;
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->is_active === 1;
    }
}