<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LoginResponse;

class AuthenticateUser
{
    public function authenticate($request)
    {
        $request->validate([
            Fortify::username() => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only(Fortify::username(), 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            // Obtener el Usuario asociado usando el username
            $usuario = Usuario::on('pgsql2')->where('per_id', $user->id)->first();

            // Log the current user and username
            Log::info('User authenticated', ['user' => $user->username]);

            // Verificar si el Usuario fue encontrado y si tiene una Persona asociada
            if ($usuario) {
                $persona = $usuario->persona;

                // Log the Persona found
                Log::info('Persona found', ['persona' => $persona]);

                if ($persona && $persona->per_cedula) {
                    $user->cedula = $persona->per_cedula;
                    $user->save();

                    // Log the updated user
                    Log::info('User updated with cedula', ['user' => $user]);
                }
            }

            return app(LoginResponse::class);
        }

        return back()->withErrors([
            Fortify::username() => trans('auth.failed'),
        ]);
    }
}