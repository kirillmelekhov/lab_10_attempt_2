<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_VISITOR = 'visitor';
    public const ROLE_LEADER = 'leader';

    /** @use HasFactory<UserFactory> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'photo_path',
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

    public function ledMasterClasses(): HasMany
    {
        return $this->hasMany(MasterClass::class, 'leader_id');
    }

    public function registeredMasterClasses(): BelongsToMany
    {
        return $this->belongsToMany(MasterClass::class, 'master_class_registrations')
            ->withTimestamps();
    }

    public function isLeader(): bool
    {
        return $this->role === self::ROLE_LEADER;
    }

    public function isVisitor(): bool
    {
        return $this->role === self::ROLE_VISITOR;
    }
}
