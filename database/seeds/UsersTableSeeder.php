<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function ($user) {
            /** @var User $user */
            switch (rand(1, 3)) {
                case 1:
                    $user->assignRole(Role::ROLE_ADMIN);
                    break;
                case 2:
                    $user->assignRole(Role::ROLE_MANAGER);
                    break;
                case 3:
                    $user->assignRole(Role::ROLE_USER);
                    break;
            }
        });
    }
}
