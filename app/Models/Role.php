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
}
