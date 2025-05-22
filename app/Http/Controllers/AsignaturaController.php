<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener solo asignaturas visibles con relaciones
        $asignaturas = Asignatura::with(['aula', 'departamento', 'profesor'])->visible()->get();
        // Obtener todas las asignaturas con relaciones
        $todasAsignaturas = Asignatura::with(['aula', 'departamento', 'profesor'])->get();
        return view('asignaturas.index', compact('asignaturas', 'todasAsignaturas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aulas = Aula::all();
        $departamentos = Departamento::all();
        $profesores = User::role('Profesor')->get();
        return view('asignaturas.create', compact('aulas', 'departamentos', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'nullable|exists:users,id',
            'aula_id' => 'nullable|exists:aulas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);

        Asignatura::create($request->all());

        return redirect()->route('asignaturas.index')->with('success', 'Asignatura creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignatura $asignatura)
    {
        return view('asignaturas.show', compact('asignatura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignatura $asignatura)
    {
        $aulas = Aula::all();
        $departamentos = Departamento::all();
        $profesores = User::role('Profesor')->get();
        return view('asignaturas.edit', compact('asignatura', 'aulas', 'departamentos', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'nullable|exists:users,id',
            'aula_id' => 'nullable|exists:aulas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);

        $asignatura->update($request->all());

        return redirect()->route('asignaturas.index')->with('success', 'Asignatura actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        //$asignatura->delete();
        $asignatura->visible = false;
        $asignatura->save();
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura eliminada correctamente.');
    }


    public function toggleVisible(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);

        if (!$asignatura) {
            return response()->json(['success' => false, 'message' => 'Asignatura no encontrada'], 404);
        }

        // Validar visible (puedes agregar validación si quieres)
        $visible = $request->input('visible');
        $asignatura->visible = $visible ? true : false;
        $asignatura->save();

        return response()->json([
            'success' => true,
            'visible' => $asignatura->visible,
            'message' => 'Visibilidad actualizada correctamente'
        ]);
    }
}
