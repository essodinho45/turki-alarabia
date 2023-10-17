<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $role = Role::create(['name' => 'Bank Employee']); //reception
        $permissions = [
            'create offer',
            'update offer',
            'print offer',
            'create order',
            'update order',
            'print order',
            'index transactions'
        ];
        foreach ($permissions as $permission)
            Permission::create(['name' => $permission]);
        $permissions = Permission::whereIn('name', $permissions)->get();
        $role->syncPermissions($permissions);
        $role = Role::create(['name' => 'Manager']); //bank branch
        Permission::create(['name' => 'approve by bank']);
        $permissions = Permission::whereIn('name', ['approve by bank', 'index transactions'])->get();
        $role->syncPermissions($permissions);
        $role = Role::create(['name' => 'Company Employee']);
        Permission::create(['name' => 'approve by manager']); //turki
        $permissions = Permission::whereIn('name', ['approve by manager', 'index transactions'])->get();
        $role->syncPermissions($permissions);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@turkialarabia.com',
            'password' => bcrypt('P@assw0rd'),
        ]);
        $user->assignRole('Super Admin');
    }
}
