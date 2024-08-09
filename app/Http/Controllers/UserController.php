<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    public function createOrUpdateUser($username)
    {
        $persona = Persona::where('per_usuario', $username)->first();
        if ($persona) {
            // Buscar el usuario en la tabla 'users' de la base de datos 'bienes'
            $user = User::where('username', $persona->per_usuario)->first();

            if (!$user) {
                // Crear el usuario solo si no existe
                $user = User::create([
                    'guid' => (string) Str::uuid(), // Generar un GUID único
                    'domain' => 'default',
                    'name' => $persona->nombre_completo ?? 'Nombre No Disponible',
                    'username' => $persona->per_usuario,
                    'email' => $persona->per_mail,
                    'password' => bcrypt('default_password'), // Ajusta la contraseña según sea necesario
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Imprimir la información del usuario creado
                Log::info('Usuario en bienes creado: ' . $user->toJson());
            } else {
                // Imprimir la información del usuario existente
                Log::info('Usuario en bienes ya existe: ' . $user->toJson());
            }
            return $user;
        }
        return null;
    }
}
