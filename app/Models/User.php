<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $remember_token
 * @property string $create_at
 * @property string $update_at
 *
 * @property Role[] $roles
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function hasRole(int $roleId): bool
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->roles->contains($roleId);
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function assignRole(int $roleId): bool
    {
        if (!$this->hasRole($roleId)) {
            $this->roles()->attach($roleId);
            return true;
        }
        return false;
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function removeRole(int $roleId): bool
    {
        if ($this->hasRole($roleId)) {
            $this->roles()->detach($roleId);
            return true;
        }
        return false;
    }
}
