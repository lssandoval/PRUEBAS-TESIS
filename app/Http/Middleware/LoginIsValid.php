<?php

namespace App\Http\Middleware;

use App\Models\Persona;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();
        if ($user) {
            // Buscar la persona por cedula en la base de datos `pgsql2`
            $persona = Persona::where('per_cedula', $user->cedula)->first();
            if ($persona && $persona->per_unidad === $role) {
                return $next($request);
            }
        }
        abort(404);
    }
}
