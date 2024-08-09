<?php

namespace App\Http\Controllers;

use App\Models\RoleHistory;
use App\Models\RolesHistoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Mail\RoleAsignadoMail;
use App\Mail\RoleAsignadoMailAdmin;
use App\Mail\RoleErrorMail;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;

class RolesController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        // Obtener datos del servicio
        $data = $this->userService->getUserData();

        // Obtener los roles disponibles
        $roles = DB::connection('pgsql')->table('roles')->pluck('name', 'id');

        // Combinar los datos y los roles en un solo array
        return view('roles_vista', array_merge($data, ['roles' => $roles]));
    }

    public function data()
    {
        try {
            // Obtener los roles disponibles
            $roles = DB::connection('pgsql')->table('roles')->pluck('name', 'id')->toArray();

            // Obtener los usuarios activos (epe_id = 1)
            $users = DB::connection('pgsql2')->table('persona')
                ->join('area', 'persona.are_id', '=', 'area.are_id')
                ->where('persona.epe_id', 1) // Filtrar por usuarios activos
                ->select(
                    'persona.per_usuario as nombre_apellido',
                    'persona.per_mail as email',
                    'area.are_nombre as coordinacion',
                    'persona.per_unidad as unidad',
                    'persona.per_id as id'
                )
                ->get();

            $usernames = $users->pluck('nombre_apellido');
            $userRoles = DB::connection('pgsql')->table('users')
                ->leftJoin('user_role_history', 'users.id', '=', 'user_role_history.user_id')
                ->whereIn('users.username', $usernames)
                ->select('users.username', 'user_role_history.role_id', 'user_role_history.estado')
                ->get()
                ->groupBy('username');

            // Formatear los datos para DataTables
            $data = $users->map(function ($user) use ($roles, $userRoles) {
                $rolesAsignados = isset($userRoles[$user->nombre_apellido])
                    ? $userRoles[$user->nombre_apellido]->filter(function ($role) {
                        return $role->estado == 1; // Solo roles activos
                    })->pluck('role_id')->toArray()
                    : [];
                $rolesAsignadosNombres = array_map(function ($roleId) use ($roles) {
                    return $roles[$roleId] ?? 'No Asignado';
                }, $rolesAsignados);

                return [
                    'nombre_apellido' => $user->nombre_apellido,
                    'email' => $user->email,
                    'coordinacion' => $user->coordinacion,
                    'unidad' => $user->unidad,
                    'role_asignado' => implode(', ', $rolesAsignadosNombres),
                    'id' => $user->id,
                    'roles' => $rolesAsignados,
                    'rolesOptions' => $roles,
                ];
            });

            return response()->json([
                'data' => $data,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            Log::error('Error in RolesController data method:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error retrieving data'], 500);
        }
    }

    /**
     * Verifica si el are_id ha cambiado y actualiza el estado de los roles.
     *
     * @param  string  $nombre_apellido
     * @return void
     */
    protected function checkAndUpdateRolesOnAreaChange($nombre_apellido)
    {
        Log::info('Verificando cambio de área para el usuario', ['nombre_apellido' => $nombre_apellido]);

        // Obtener el usuario
        $user = User::where('username', $nombre_apellido)->first();
        if (!$user) {
            Log::error('Usuario no encontrado para la actualización de área', ['nombre_apellido' => $nombre_apellido]);
            return;
        }
        Log::info('Usuario encontrado', ['user_id' => $user->id]);

        // Obtener el are_id actual del usuario desde la base de datos 'portal'
        $currentAreaId = DB::connection('pgsql2')->table('persona')
            ->where('per_usuario', $nombre_apellido)
            ->value('are_id');
        Log::info('Área actual del usuario', ['current_area_id' => $currentAreaId]);

        // Obtener el are_id previo del usuario desde RolesHistoria
        $previousAreaId = RolesHistoria::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->value('are_id');
        Log::info('Área previa del usuario', ['previous_area_id' => $previousAreaId]);

        // Si el are_id ha cambiado, actualizar el estado de los roles
        if ($currentAreaId !== $previousAreaId) {
            Log::info('Área ha cambiado', [
                'nombre_apellido' => $nombre_apellido,
                'previous_area_id' => $previousAreaId,
                'current_area_id' => $currentAreaId,
            ]);

            // Obtener roles actuales del usuario
            $currentRoles = $user->roles->pluck('id')->toArray();
            Log::info('Roles actuales del usuario', ['current_roles' => $currentRoles]);

            // Inactivar los roles del usuario
            foreach ($currentRoles as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $user->removeRole($role);
                    Log::info('Rol inactivado debido al cambio de área', ['user_id' => $user->id, 'role_id' => $roleId]);

                    // Marcar el rol en el historial como inactivo
                    RolesHistoria::where('user_id', $user->id)
                        ->where('role_id', $roleId)
                        ->update(['estado' => 0]);
                    Log::info('Estado del rol actualizado a inactivo en RolesHistoria', ['user_id' => $user->id, 'role_id' => $roleId]);
                } else {
                    Log::warning('Rol no encontrado durante la inactivación', ['role_id' => $roleId]);
                }
            }

            // Registrar el cambio de área en RolesHistoria
            RolesHistoria::create([
                'user_id' => $user->id,
                'role_id' => null, // No aplicable
                'estado' => 0, // Inactivo
                'asignador' => 'Sistema',
                'are_id' => $currentAreaId // Registrar nuevo are_id
            ]);
            Log::info('Cambio de área registrado en RolesHistoria', ['user_id' => $user->id, 'are_id' => $currentAreaId]);
        } else {
            Log::info('No se detectaron cambios en el área para el usuario', ['nombre_apellido' => $nombre_apellido]);
        }
    }

    public function updateRoles(Request $request, $nombre_apellido)
    {

        $user = User::where('username', $nombre_apellido)->first();
        if (!$user) {
            Log::error('Usuario no encontrado', ['nombre_apellido' => $nombre_apellido]);
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $roles = $request->input('roles', []);
        $estadoNuevo = $request->input('estado', 1); // Obtener el nuevo estado del usuario

        if (empty($roles)) {
            Log::warning('No se han seleccionado roles', ['roles' => $roles]);
            return response()->json(['error' => 'No se han seleccionado roles'], 400);
        }

        $userId = $user->id;

        // Obtener roles actuales del usuario
        $currentRoles = $user->roles->pluck('id')->toArray();

        // Nuevos roles que se van a agregar
        $newRoles = array_diff($roles, $currentRoles);

        // Roles que ya no están en la solicitud
        $rolesToRemove = array_diff($currentRoles, $roles);

        // Asignar nuevos roles
        foreach ($newRoles as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $user->assignRole($role);
                Log::info('Rol asignado al usuario', ['user_id' => $userId, 'role_id' => $roleId]);

                RolesHistoria::create([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                    'estado' => ($estadoNuevo == 1) ? 1 : 0, // Estado ACTIVO si epe_id es 1, INACTIVO si es 2
                    'asignador' => $request->user() ? $request->user()->name : 'Desconocido'
                ]);
            } else {
                Log::warning('Rol no encontrado', ['role_id' => $roleId]);
            }
        }

        // Eliminar roles no deseados (inactivar en lugar de eliminar)
        foreach ($rolesToRemove as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $user->removeRole($role);
                Log::info('Rol eliminado del usuario', ['user_id' => $userId, 'role_id' => $roleId]);

                // Marcar el rol en el historial como eliminado (estado = 0)
                RolesHistoria::where('user_id', $userId)
                    ->where('role_id', $roleId)
                    ->update(['estado' => 0]);
                Log::info('Estado actualizado a INACTIVO en RolesHistoria', ['user_id' => $userId, 'role_id' => $roleId]);
            } else {
                Log::warning('Rol no encontrado', ['role_id' => $roleId]);
            }
        }

        // Si el estado del usuario cambia a inactivo (epe_id = 2)
        if ($estadoNuevo == 2) {
            // Eliminar todos los roles asignados (inactivar en lugar de eliminar)
            foreach ($currentRoles as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $user->removeRole($role);
                    Log::info('Rol eliminado del usuario debido a inactividad', ['user_id' => $userId, 'role_id' => $roleId]);

                    // Marcar el rol en el historial como inactivo (estado = 0)
                    RolesHistoria::where('user_id', $userId)
                        ->where('role_id', $roleId)
                        ->update(['estado' => 0]);
                    Log::info('Estado actualizado a INACTIVO en RolesHistoria', ['user_id' => $userId, 'role_id' => $roleId]);
                } else {
                    Log::warning('Rol no encontrado', ['role_id' => $roleId]);
                }
            }
        }


        // Obtener el are_id del usuario desde la base de datos 'portal'
        $currentAreaId = DB::connection('pgsql2')->table('persona')
            ->where('per_usuario', $nombre_apellido)
            ->value('are_id');
        Log::info('Área actual obtenida de la tabla persona', ['current_area_id' => $currentAreaId]);

        // Verificar si $currentAreaId es válido
        if (!$currentAreaId) {
            Log::error('are_id no encontrado', ['nombre_apellido' => $nombre_apellido]);
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Obtener el ID del usuario desde la base de datos 'users'
        $perIdUsuario = DB::connection('pgsql')->table('users')
            ->where('username', $nombre_apellido)
            ->value('id');
        Log::info('ID DE USUARIO', ['perIdUsuario' => $perIdUsuario]);

        // Verificar si $perIdUsuario es válido
        if (!$perIdUsuario) {
            Log::error('Usuario en base de datos no encontrado', ['username' => $nombre_apellido]);
            return response()->json(['error' => 'Usuario en base de datos no encontrado'], 404);
        }

        // Actualizar el are_id del usuario en la base de datos 'user_role_history'
        DB::connection('pgsql')->table('user_role_history')
            ->where('user_id', $perIdUsuario)
            ->update(['are_id' => $currentAreaId]);
        Log::info('are_id actualizado en la tabla user_role_history', [
            'nombre_apellido' => $nombre_apellido,
            'user_id' => $perIdUsuario,
            'are_id' => $currentAreaId
        ]);

        // Continuar con la asignación y eliminación de roles como en el código anterior...

        // Enviar correos y manejar la respuesta
        try {
            // Enviar correo al usuario
            $userEmail = DB::connection('pgsql2')->table('persona')
                ->where('per_usuario', $nombre_apellido)
                ->value('per_mail');

            $adminEmails = ['inteligencia@cosede.gob.ec', 'soporte@cosede.gob.ec'];

            if ($userEmail) {
                Mail::to($userEmail)->send(new RoleAsignadoMail($user->name, implode(', ', $roles), now()->toDateString()));
            }

            Mail::to($adminEmails)->send(new RoleAsignadoMailAdmin($user->name, implode(', ', $roles), now()->toDateString()));

            Log::info('Roles actualizados correctamente', ['user_id' => $user->id ?? 'No user found']);
            return response()->json(['success' => 'Roles actualizados correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar roles', ['exception' => $e]);

            // Enviar correo de error al usuario
            if ($userEmail) {
                Mail::to($userEmail)->send(new RoleErrorMail($user->name));
            }

            // Enviar correo de error a administradores tecnológicos
            Mail::to($adminEmails)->send(new RoleErrorMail($user->name));

            return response()->json(['error' => 'Error al actualizar roles'], 500);
        }
    }




    public function removeRoles(Request $request, $nombre_apellido)
    {
        Log::info('Received request to remove roles', [
            'username' => $nombre_apellido,
            'request_data' => $request->all()
        ]);

        $user = User::where('username', $nombre_apellido)->first();
        if (!$user) {
            Log::error('Usuario no encontrado', ['username' => $nombre_apellido]);
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $roleIds = $request->input('roles', []);
        if (empty($roleIds)) {
            Log::warning('No se han seleccionado roles para eliminar', ['roles' => $roleIds]);
            return response()->json(['error' => 'No se han seleccionado roles'], 400);
        }

        $userId = $user->id;
        foreach ($roleIds as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $user->removeRole($role);
                Log::info('Rol eliminado del usuario', ['user_id' => $userId, 'role_id' => $roleId]);

                // Marcar el rol en el historial como eliminado (estado = 0)
                RolesHistoria::where('user_id', $userId)
                    ->where('role_id', $roleId)
                    ->update(['estado' => 0]);
                Log::info('Estado actualizado a INACTIVO en user_role_history', ['user_id' => $userId, 'role_id' => $roleId]);
            } else {
                Log::warning('Rol no encontrado', ['role_id' => $roleId]);
            }
        }

        Log::info('Roles eliminados correctamente', ['user_id' => $user->id ?? 'No user found']);
        return response()->json(['success' => 'Roles eliminados correctamente']);
    }
}
