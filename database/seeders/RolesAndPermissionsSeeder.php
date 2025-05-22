<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpia la caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); 

        // Permisos agrupados por rol, adaptados a rutas y funcionalidades
        $permissions = [
            'Administrador' => [ 'administrar',
                'admin.index', 'admin.create', 'admin.edit', 'admin.destroy', 'admin.toggle-visible',
                'role.index', 'role.create', 'role.edit', 'role.destroy',
                'permissions.index', 'permissions.create', 'permissions.edit', 'permissions.destroy',
                'profile.index', 'profile.create', 'profile.show','profile.edit', 'profile.destroy',
                'aulas.index', 'aulas.create', 'aulas.edit', 'aulas.destroy', 'aulas.toggle-visible',
                'departamentos.index', 'departamentos.create', 'departamentos.edit', 'departamentos.destroy',
                'asignaturas.index', 'asignaturas.create', 'asignaturas.show','asignaturas.edit', 'asignaturas.destroy', 'asignaturas.toggle-visible',
                'horarios.index', 'horarios.create', 'horarios.edit', 'horarios.destroy', 'horarios.toggle-visible',
                'notas.index', 'notas.create', 'notas.edit', 'notas.destroy', 'notas.toggle-visible',
            ],

            'Profesor' => [ 'profesor',
                'asignaturas.index',
                'horarios.index',
                'aulas.index',
                'notas.index', 'notas.create', 'notas.edit',
                'profile.index', 'profile.edit',
            ],

            'Invitado' => [
                'profile.index', 'profile.edit',
            ],
        ];

        // Crear todos los permisos únicos
        $allPermissions = collect($permissions)->flatten()->unique();

        foreach ($allPermissions as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles y asignar permisos
        foreach ($permissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);

            // Permisos generales para control lógico (opcional)
            if ($roleName === 'Administrador') {
                $role->givePermissionTo('administrar');
            } elseif ($roleName === 'Profesor') {
                $role->givePermissionTo('profesor');
            }
        }

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@edu.gva.es'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin123'),
                'visible' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Administrador');

        // Crear profesores con nombres aleatorios
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $email = "profesor{$i}@edu.gva.es";
            $name = $faker->name;

            $profesor = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt('profesor123'),
                    'visible' => true,
                    'email_verified_at' => now(),
                ]
            );

            $profesor->assignRole('Profesor');
        }

        // Crear usuario invitado
        $guest = User::firstOrCreate(
            ['email' => 'invitado@edu.gva.es'],
            [
                'name' => 'Usuario Invitado',
                'password' => bcrypt('invitado123'),
                'visible' => true,
                'email_verified_at' => now(),
            ]
        );
        $guest->assignRole('Invitado');
    }
}
