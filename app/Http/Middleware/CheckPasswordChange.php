<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->debe_cambiar_contrasena && !$request->is('cambiar-contrasena') && !$request->is('logout')) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}

