<?php

namespace App\Services;

use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getUserData()
    {
        $user = Auth::user();
        $persona = null;
        $rolesAsignadosNombres = ['No asignado']; // Inicializar como array
        $coordinacion = 'No asignado';

        if ($user) {
            // Obtener la información de la persona basada en el usuario autenticado
            $persona = Persona::where('per_usuario', $user->username)->first();

            if ($persona) {
                // Obtener los roles disponibles
                $roles = DB::connection('pgsql')->table('roles')->pluck('name', 'id')->toArray();

                // Obtener los roles asignados al usuario
                $userRoles = DB::connection('pgsql')->table('users')
                    ->leftJoin('user_role_history', 'users.id', '=', 'user_role_history.user_id')
                    ->where('users.username', $user->username)
                    ->select('user_role_history.role_id', 'user_role_history.estado')
                    ->get()
                    ->filter(function ($role) {
                        return $role->estado == 1; // Solo roles activos
                    })->pluck('role_id')->toArray();

                // Obtener los nombres de los roles asignados
                $rolesAsignadosNombres = array_map(function ($roleId) use ($roles) {
                    return $roles[$roleId] ?? 'No Asignado';
                }, $userRoles);

                // Obtener la coordinación
                if ($persona->area) {
                    $coordinacion = $persona->area->are_nombre;
                }
            }
        }

        return compact('persona', 'rolesAsignadosNombres', 'coordinacion');
    }
}
