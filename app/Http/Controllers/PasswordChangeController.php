<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function showForm()
    {
        return view('auth.cambiar-contrasena');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->debe_cambiar_contrasena = false;
        $user->save();

        return redirect()->route('home')->with('success', 'Contraseña actualizada correctamente.');
    }
}
