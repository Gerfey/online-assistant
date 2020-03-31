<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([[
            'id' => Role::ROLE_ADMIN,
            'code' => 'admin',
            'name' => 'Администратор'
        ], [
            'id' => Role::ROLE_MANAGER,
            'code' => 'manager',
            'name' => 'Менеджер'
        ], [
            'id' => Role::ROLE_USER,
            'code' => 'user',
            'name' => 'Пользователь'
        ]]);
    }
}
