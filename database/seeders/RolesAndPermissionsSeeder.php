<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Departamento;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpia la caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); 

        $permissions = [
            'Administrador' => [
                'administrar', // acceso total (puede seguir siendo utilizado en los middlewares)

                // Usuarios
                'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar', 'usuarios.toggle',

                // Roles y permisos
                'roles.ver', 'roles.crear', 'roles.editar', 'roles.eliminar',
                'permisos.ver', 'permisos.crear', 'permisos.editar', 'permisos.eliminar',

                // Perfil
                'perfil.ver', 'perfil.crear', 'perfil.mostrar', 'perfil.editar', 'perfil.eliminar',

                // Aulas
                'aulas.ver', 'aulas.crear', 'aulas.editar', 'aulas.eliminar', 'aulas.toggle',

                // Departamentos
                'departamentos.ver', 'departamentos.crear', 'departamentos.editar', 'departamentos.eliminar',

                // Asignaturas
                'asignaturas.ver', 'asignaturas.crear', 'asignaturas.mostrar', 'asignaturas.editar', 'asignaturas.eliminar', 'asignaturas.toggle',

                // Horarios
                'horarios.ver', 'horarios.crear', 'horarios.editar', 'horarios.eliminar', 'horarios.toggle',

                // Notas
                'notas.ver', 'notas.crear', 'notas.editar', 'notas.eliminar', 'notas.toggle',
            ],

            'Profesor' => [
                'profesor', // acceso al menú profesor

                // Vista de sus recursos
                'asignaturas.ver',
                'horarios.ver',
                'aulas.ver',
                'notas.ver', 'notas.crear', 'notas.editar',
                'perfil.ver', 'perfil.editar',
            ],

            'Invitado' => [
                'invitados',
                'aulas.ver',
                'profesores.ver',
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
            $email = "informatica_profesor{$i}@edu.gva.es";
            $name = $faker->name;

            $profesor = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt('profesor123'),
                    'visible' => true,
                    'email_verified_at' => now(),
                    'debe_cambiar_contrasena' => true,
                ]
            );

            $profesor->assignRole('Profesor');
        }
        // Profesores por departamento
        $departamentos = Departamento::pluck('id', 'nombre')->toArray();

        foreach ($departamentos as $nombreDepto => $idDepto) {
            $numProfesores = rand(2, 4); // Puedes ajustar esta cantidad

            for ($i = 1; $i <= $numProfesores; $i++) {
                $email = $this->normalizarNombreDepto($nombreDepto) . "_prof{$i}@edu.gva.es";
                $name = $faker->name;

                $profesor = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => bcrypt('profesor123'),
                        'visible' => true,
                        'email_verified_at' => now(),
                        'debe_cambiar_contrasena' => true,
                    ]
                );

                $profesor->assignRole('Profesor');

                // Opcional: puedes guardar en un campo `departamento_id` si tu modelo User lo tiene
                // $profesor->departamento_id = $idDepto;
                // $profesor->save();
            }
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
    private function normalizarNombreDepto($nombre)
    {
        $nombre = strtolower($nombre);
        $nombre = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre);
        return preg_replace('/[^a-z]/', '', $nombre); // Elimina todo excepto letras
    }
    
}
