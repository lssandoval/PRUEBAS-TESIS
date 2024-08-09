<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    // Middleware
    public function handle($request, Closure $next, $roleName)
    {
        $user = Auth::user();

        Log::info('CheckRole Middleware:', ['user' => $user, 'roleName' => $roleName]);

        if ($user && $user->hasRole($roleName)) {
            Log::info('User has role:', ['user_id' => $user->id, 'role_name' => $roleName]);
            return $next($request);
        }

        Log::warning('User does not have role:', ['user_id' => $user ? $user->id : null, 'role_name' => $roleName]);
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta ruta.');
    }
}
