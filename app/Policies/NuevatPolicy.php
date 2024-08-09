<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Nuevat;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class NuevatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $persona = $user->persona;

        if (!$persona) {
            return false; // O retorna true si quieres permitir acceso a todos los usuarios sin relación
        }

        return in_array($persona->per_unidad, ['UTIC', 'UIN', 'any']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nuevat  $nuevat
     * @return mixed
     */
    public function view(User $user, Nuevat $nuevat)
    {
        $persona = $user->persona;
        Log::info('Persona:', ['persona' => $persona]);
        if (!$persona) {
            return false; // O retorna true si quieres permitir acceso a todos los usuarios sin relación
        }

        return in_array($persona->per_unidad, ['UTIC', 'UIN', 'any']);
    }
}
