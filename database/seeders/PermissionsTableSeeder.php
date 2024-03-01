<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permission for roles
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        Permission::create(['name' => 'pemesanans.index']);
        Permission::create(['name' => 'pemesanans.create']);
        Permission::create(['name' => 'pemesanans.edit']);
        Permission::create(['name' => 'pemesanans.delete']);

        Permission::create(['name' => 'kendaraans.index']);
        Permission::create(['name' => 'kendaraans.create']);
        Permission::create(['name' => 'kendaraans.edit']);
        Permission::create(['name' => 'kendaraans.delete']);

        Permission::create(['name' => 'supirs.index']);
        Permission::create(['name' => 'supirs.create']);
        Permission::create(['name' => 'supirs.edit']);
        Permission::create(['name' => 'supirs.delete']);

        Permission::create(['name' => 'pengelolas.index']);
        Permission::create(['name' => 'pengelolas.create']);
        Permission::create(['name' => 'pengelolas.edit']);
        Permission::create(['name' => 'pengelolas.delete']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index']);

        //permission for users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
    }
}
