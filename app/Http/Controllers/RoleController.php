<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        $roles=Role::select('id','name')->get();
        
        
        return view("role.index", compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("role.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Validar que el nombre sea requerido y único
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        // Crear nuevo rol
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        // Redireccionar con mensaje
        return redirect()->route('role.index')->with('success', 'Rol creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $permission = Permission::all(); 

        $role = Role::with('permissions')->find($id);

        $permisos_rol = $role->permissions->pluck('id')->toArray();
       
        return view("role.edit", compact('permission', 'role', 'permisos_rol'));

        
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

        app()['cache']->forget('spatie.permission.cache');
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permissions', []));



        $usuarios = $role->users;

         // Asignar los mismos permisos a cada usuario asociado al rol
            foreach ($usuarios as $usuario) {
                $usuario->syncPermissions($role->permissions);
            }

      
       
        return redirect()->route('role.index')->with('success', 'Rol actualizado correctamente.');
    }


    public function update1(Request $request, $id)
    {
        app()['cache']->forget('spatie.permission.cache');
    
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);
    
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permissions', []));
    
        foreach ($role->users as $usuario) {
            $usuario->syncPermissions($role->permissions);
        }
    
        return redirect()->route('role.index')->with('success', 'Rol actualizado correctamente.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar el rol por ID
        $role = Role::findOrFail($id);

        // Evita eliminar roles críticos si necesitas lógica condicional
        if (in_array($role->name, ['admin', 'superadmin'])) {
            return redirect()->route('role.index')->with('error', 'Este rol no se puede eliminar.');
        }

        // Eliminar relaciones y el rol
        $role->permissions()->detach(); // Limpia permisos si es necesario
        $role->delete();

        // Redireccionar con mensaje de éxito
        return redirect()->route('role.index')->with('success', 'Rol eliminado correctamente.');
    }

}
