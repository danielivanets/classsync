<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$aulas = Aula::select('id', 'nombre', 'capacidad', 'tipo', 'ubicacion', 'disponible')->where('visible', true)->get();
        $aulas = Aula::visible()->get(); // Aulas visibles para mostrar en la tabla principal
        $todasAulas = Aula::all(); // Todas las aulas (para el modal)
        return view('aulas.index', compact('aulas','todasAulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'tipo' => 'required|string',
        ]);

        Aula::create($request->all());
        
        return redirect()->route('aulas.index')->with('success', 'Aula creada correctamente.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aula = Aula::findOrFail($id);
        return view('aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'nullable|integer|min:1',
            'tipo' => 'required|string',
            'ubicacion' => 'nullable|string|max:100',
            'disponible' => 'sometimes|boolean',
            'visible' => 'sometimes|boolean',
        ]);

        $aula = Aula::findOrFail($id);

        // Actualiza solo los campos validados
        $aula->update($validatedData);

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aula = Aula::findOrFail($id);
        $aula->visible = false;
        $aula->save();
        return redirect()->route('aulas.index')->with('success', 'Usuario eliminado correctamente.');
    }


    public function toggleVisible(Request $request, $id)
    {
        $aula = Aula::findOrFail($id);
        $aula->visible = $request->visible ? true : false;
        $aula->save();

        return response()->json([
            'success' => true,
            'visible' => $aula->visible
        ]);
    }
}
