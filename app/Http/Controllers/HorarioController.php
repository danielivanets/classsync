<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Aula;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            // Horarios visibles del profesor
            $horarios = Horario::visible()
                ->delProfesor($user->id)
                ->with(['asignatura', 'aula'])
                ->get();

            // Mostrar el modal al profesor
            $todosHorarios = collect(); 
        } else {
            // administradores y otros roles
            $horarios = Horario::visible()->with(['asignatura', 'aula'])->get();
            $todosHorarios = Horario::with(['asignatura', 'aula'])->get();
        }

        return view('horarios.index', compact('horarios', 'todosHorarios'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $asignaturas = Asignatura::visible()->get();
        $aulas = Aula::visible()->get();
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        return view('horarios.create', compact('asignaturas', 'aulas', 'dias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'aula_id' => 'required|exists:aulas,id',
        ],
        [
            'dia.required' => 'El campo día es obligatorio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'asignatura_id.exists' => 'La asignatura seleccionada no existe.',
            'aula_id.required' => 'Debe seleccionar un aula.',
            'aula_id.exists' => 'El aula seleccionada no existe.',
        ]);

        Horario::create([
            ...$request->only(['dia', 'hora_inicio', 'hora_fin', 'asignatura_id', 'aula_id']),
            'visible' => true
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        $asignaturas = Asignatura::visible()->with(['profesor', 'aula'])->get();
        $aulas = Aula::visible()->get();
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        $horario->hora_inicio = \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i');
        $horario->hora_fin = \Carbon\Carbon::parse($horario->hora_fin)->format('H:i');

        return view('horarios.edit', compact('horario', 'asignaturas', 'aulas', 'dias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'aula_id' => 'required|exists:aulas,id',
            'visible' => 'sometimes|boolean',
        ],
        [
            'dia.required' => 'El campo día es obligatorio.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'asignatura_id.exists' => 'La asignatura seleccionada no existe.',
            'aula_id.required' => 'Debe seleccionar un aula.',
            'aula_id.exists' => 'El aula seleccionada no existe.',
            'visible.boolean' => 'El campo visible debe ser verdadero o falso.',
        ]);
    
        $horario->update($request->all());
    
        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->visible = false;
        $horario->save();
    
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }

    public function toggleVisible(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->visible = $request->visible ? true : false;
        $horario->save();

        return response()->json([
            'success' => true,
            'visible' => $horario->visible
        ]);
    }
}
