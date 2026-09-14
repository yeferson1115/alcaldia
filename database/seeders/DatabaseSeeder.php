<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
         // Crear permisos
    $permission1 = Permission::create(['name' => 'create-post']);
    $permission2 = Permission::create(['name' => 'edit-post']);

    // Crear roles
    $role1 = Role::create(['name' => 'admin']);
    $role2 = Role::create(['name' => 'editor']);

    // Asignar permisos a roles
    $role1->givePermissionTo($permission1);
    $role1->givePermissionTo($permission2);

    $role2->givePermissionTo($permission1);
    
    // Asignar roles a usuarios
    $user = \App\Models\User::find(1);
    $user->assignRole('admin');
    }
}
