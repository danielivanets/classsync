<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')
                    ->where('visible', true)
                    ->get();
        $todosUsuarios = User::with('roles')->get();

        return view("admin.index", compact('users', 'todosUsuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(); 
        return view("admin.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles'    => 'required|array',
        ],
        [
            // Mensajes genéricos
            'required' => 'El campo :attribute es obligatorio.',
            'email'    => 'El campo :attribute debe ser una dirección de correo válida.',
            'unique'   => 'El campo :attribute ya ha sido registrado.',
            'confirmed'=> 'La confirmación de :attribute no coincide.',
            'min.string' => 'El campo :attribute debe tener al menos :min caracteres.',
        ], [
            // Traducción de los atributos
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
            'roles' => 'roles',
        ]);

        // Creación del usuario
        $usuario = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignación de roles
        $usuario->syncRoles($request->roles);

        // Obtener permisos de los roles y asignarlos al usuario
        $roles = $usuario->roles;
        $permisos = $roles->flatMap->permissions->pluck('name')->unique();
        $usuario->syncPermissions($permisos);

        return redirect()->route('admin.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('roles.permissions')->findOrFail($id);
        $roles_usuario = $user->roles->pluck('id')->toArray();

        return view("admin.edit", compact('user', 'roles', 'roles_usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id, // Para excluir el email actual del usuario
            'roles'    => 'required|array', // Asegúrate de que los roles sean un array
        ],[
            // Mensajes genéricos
            'required'   => 'El campo :attribute es obligatorio.',
            'email'      => 'El campo :attribute debe ser una dirección de correo válida.',
            'unique'     => 'El campo :attribute ya ha sido registrado.',
            'confirmed'  => 'La confirmación de :attribute no coincide.',
            'min.string' => 'El campo :attribute debe tener al menos :min caracteres.',
        ], [
            // Traducción de los atributos
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
            'roles' => 'roles',
        ]);

        // Actualización del usuario
        $usuario = User::findOrFail($id);
        $usuario->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Si se proporciona una nueva contraseña, se actualiza
        if ($request->filled('password')) {
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        // Actualización de los roles
        $usuario->syncRoles($request->input('roles', []));
        
        // Obtener permisos de los roles y asignarlos al usuario
        $roles = $usuario->roles;
        $permisos = $roles->flatMap->permissions->pluck('name')->unique();
        $usuario->syncPermissions($permisos);

        return redirect()->route('admin.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //$usuario->delete();
        $user->visible = false;
        $user->save();
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleVisible(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->visible = $request->input('visible') ? true : false;
        $user->save();

        return response()->json([
            'success' => true,
            'visible' => $user->visible
        ]);
    }

    public function profesores()
    {
        $users = User::select('id', 'name', 'email')
                    ->where('visible', true)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Profesor');
                    })
                    ->get();

        return view('admin.profesores-index', compact('users'));
    }

}
