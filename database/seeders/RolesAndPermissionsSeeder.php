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
        Role::firstOrCreate(['name' => 'Super Admin']);
        $role = Role::firstOrCreate(['name' => 'Bank Employee']); //reception
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
            Permission::firstOrCreate(['name' => $permission]);
        $permissions = Permission::whereIn('name', $permissions)->get();
        $role->syncPermissions($permissions);
        $role = Role::firstOrCreate(['name' => 'Manager']); //bank branch
        Permission::firstOrCreate(['name' => 'approve by bank']);
        $permissions = Permission::whereIn('name', ['approve by bank', 'index transactions'])->get();
        $role->syncPermissions($permissions);
        $role = Role::firstOrCreate(['name' => 'Company Employee']);
        Permission::firstOrCreate(['name' => 'approve by manager']); //turki
        $permissions = Permission::whereIn('name', ['approve by manager', 'index transactions'])->get();
        $role->syncPermissions($permissions);
        $user = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@turkialarabia.com',
            'password' => bcrypt('P@assw0rd'),
        ]);
        $user->assignRole('Super Admin');
    }
}
