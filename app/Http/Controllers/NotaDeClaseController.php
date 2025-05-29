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
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            // Usamos la relación y scope visible, ordenando por id descendente
            $notas = $user->notasDeClase()
                        ->with(['asignatura', 'usuario'])
                        ->visible()
                        ->orderBy('id', 'desc')
                        ->get();

            $todasNotas = collect(); // No mostrar modal para profesores
        } else {
            // Admins y otros roles con acceso completo, ordenando también
            $notas = NotaDeClase::with(['asignatura', 'usuario'])
                                ->visible()
                                ->orderBy('id', 'desc')
                                ->get();

            $todasNotas = NotaDeClase::with(['asignatura', 'usuario'])
                                    ->orderBy('id', 'desc')
                                    ->get();
        }

        return view('notas.index', compact('notas', 'todasNotas'));
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            // Solo asignaturas del profesor autenticado
            $todasAsignaturas = Asignatura::with(['departamento'])
                ->where('usuario_id', $user->id)
                ->visible()
                ->get();

            $profesores = collect([$user]); // Solo el usuario actual
        } else {
            $todasAsignaturas = Asignatura::with(['profesor', 'departamento'])->visible()->get();
            $profesores = User::role('Profesor')->get();
        }

        return view('notas.create', compact('todasAsignaturas', 'profesores', 'user'));
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

        $validated['visible'] = true;
    
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
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            // Solo las asignaturas del profesor autenticado
            $asignaturas = Asignatura::with(['profesor', 'departamento'])
                ->where('usuario_id', $user->id)
                ->visible()
                ->get();

            // El profesor será el usuario autenticado
            $profesores = collect([$user]);
        } else {
            // Admin u otros roles
            $asignaturas = Asignatura::with(['profesor', 'departamento'])->visible()->get();
            $profesores = User::role('Profesor')->get();
        }

        $nota->fecha = \Carbon\Carbon::parse($nota->fecha);

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

    public function getAsignaturasPorProfesor($id)
    {
        $asignaturas = Asignatura::with(['departamento'])
        ->where('usuario_id', $id)
        ->visible()
        ->get();

        return response()->json($asignaturas);
    }

}
