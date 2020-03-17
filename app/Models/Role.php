<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property string $name
 */
class Role extends Model
{
    protected $table = 'roles';

    public const ROLE_ADMIN = 1;
    public const ROLE_MANAGER = 2;
    public const ROLE_USER = 3;
}
