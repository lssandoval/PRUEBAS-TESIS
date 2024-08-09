<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetCookieAfterAuthentication
{
    public function __invoke(Request $request, $next)
    {
        // Obtén el nombre de usuario y otros datos que deseas almacenar en cookies.
        $username = $request->user()->username;

        // Asegúrate de no almacenar contraseñas sin cifrar en cookies.
        // Si es absolutamente necesario almacenar algo relacionado con la contraseña,
        // considera usar un hash o un token seguro.
        $hashedPassword = bcrypt($request->user()->password); // Como ejemplo, cifrando la contraseña

        // Establece las cookies con los datos del usuario autenticado.
        Cookie::queue('custom_username', $username, 60); // 60 minutos como ejemplo
        Cookie::queue('custom_password', $hashedPassword, 60); // No recomendado, usar con precaución

        return $next($request);
    }
}
