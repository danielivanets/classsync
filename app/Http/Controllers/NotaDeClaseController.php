<?php

namespace App\Http\Controllers;

use App\Models\NotaDeClase;
use App\Models\Asignatura;
use App\Models\User;
use Illuminate\Http\Request;

class NotaDeClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = NotaDeClase::with(['asignatura', 'usuario'])->visible()->get();
        $todasNotas = NotaDeClase::with(['asignatura', 'usuario'])->get();

        return view('notas.index', compact('notas', 'todasNotas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $todasAsignaturas = Asignatura::with('profesor')->visible()->get();
        $profesores = User::role('Profesor')->get();
        return view('notas.create', compact('todasAsignaturas', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after_or_equal:hora_inicio',
            'contenido' => 'required|string',
            'tema' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
        ]);
    
        // Añadir visibilidad como true/false explícitamente
        $validated['visible'] = $request->has('visible');
    
        NotaDeClase::create($validated);
    
        return redirect()->route('notas.index')->with('success', 'Nota de clase creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotaDeClase $nota)
    {
        $nota->fecha = \Carbon\Carbon::parse($nota->fecha);
        $asignaturas = Asignatura::with('profesor')->visible()->get();
        $profesores = User::role('Profesor')->get();

        return view('notas.edit', compact('nota', 'asignaturas', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotaDeClase $nota)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after_or_equal:hora_inicio',
            'contenido' => 'required|string',
            'tema' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'visible' => 'boolean'
        ]);

        $nota->update($request->all());

        return redirect()->route('notas.index')->with('success', 'Nota de clase actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotaDeClase $nota)
    {
        $nota->visible = false;
        $nota->save();
    
        return redirect()->route('notas.index')->with('success', 'Nota de clase eliminada correctamente.');
    }

    public function toggleVisible(NotaDeClase $nota)
    {
        $nota->visible = !$nota->visible;
        $nota->save();

        return response()->json([
            'success' => true,
            'visible' => $nota->visible,
        ]);
    }

}
