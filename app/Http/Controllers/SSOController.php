<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SSOController extends Controller
{
    protected $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function login(Request $request)
    {
        // Obtener el token de la solicitud
        $token = $request->input('token');

        // Verificar que el token no esté vacío
        if (empty($token)) {
            // Redirigir al URL externo en caso de error
            return $this->redirectToExternalUrl('Token de autenticación no proporcionado');
        }

        // Extraer el nombre de usuario del token
        $perUsuario = $this->getUsernameFromToken($token);

        // Buscar la persona en la base de datos
        $persona = Persona::where('per_usuario', $perUsuario)
            ->where('epe_id', 1)
            ->first();

        if ($persona) {
            // Crear o actualizar el usuario en el sistema
            $user = $this->userController->createOrUpdateUser($perUsuario);

            if ($user) {
                // Iniciar sesión del usuario
                Auth::login($user);
                return redirect('dashboard');
            } else {
                // Redirigir al URL externo en caso de fallo en creación o actualización de usuario
                return $this->redirectToExternalUrl('No se pudo crear o actualizar el usuario');
            }
        } else {
            // Redirigir al URL externo en caso de credenciales incorrectas o epe_id no válido
            return $this->redirectToExternalUrl('Credenciales Incorrectas o epe_id no válido');
        }
    }

    protected function getUsernameFromToken($token)
    {
        // Decodificar el token y extraer el nombre de usuario
        $decoded = base64_decode($token);
        $parts = explode(':', $decoded);

        // Verificar que el formato del token sea correcto
        if (count($parts) < 1) {
            throw new \Exception('Token mal formado');
        }

        return $parts[0];
    }

    /**
     * Redirige al usuario a una URL externa con un mensaje de error.
     *
     * @param string $message El mensaje de error para mostrar.
     * @return \Illuminate\Http\Response
     */
    protected function redirectToExternalUrl($message)
    {
        // Puedes agregar el mensaje de error como parámetro en la URL si es necesario
        $url = 'http://depintranet.cosede.gob.ec/intranet/';
        // Redirigir al usuario a la URL externa
        return redirect()->away($url);
    }
}
