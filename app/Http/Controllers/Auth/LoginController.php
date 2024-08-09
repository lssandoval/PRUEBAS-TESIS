<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Obtener las cookies desde el request
        $username = $request->cookie('username'); // Ajusta el nombre de la cookie si es necesario
        $password = $request->cookie('password'); // Ajusta el nombre de la cookie si es necesario

        Log::info('Cookies obtenidas:', ['username' => $username, 'password' => $password]);

        if ($username && $password) {
            // Enviar los datos a WordPress para validación
            $response = Http::withHeaders([
                'X-CSRF-Token' => $request->header('X-CSRF-Token'),
            ])->post('http://depbienestecnologicos.cosede.gob.ec/proxy.php', [
                'username' => $username,
                'password' => $password,
            ]);

            // Imprimir la respuesta para depuración
            Log::info('Respuesta de WordPress:', ['response' => $response->body()]);

            // Validar la respuesta
            if ($response->ok()) {
                $credentials = $response->json();

                Log::info('Credenciales recibidas:', ['credentials' => $credentials]);

                // Validar las credenciales en Laravel
                $validated = Auth::validate([
                    'samaccountname' => $credentials['username'],
                    'password' => $credentials['password'],
                ]);

                if ($validated) {
                    Log::info('Autenticación en Laravel exitosa.');

                    // Suponiendo que recibes el ID del usuario en la respuesta
                    Auth::loginUsingId($credentials['user_id']);
                    return redirect('/dashboard');
                } else {
                    Log::warning('Credenciales no válidas en Laravel.');
                }
            } else {
                Log::warning('Respuesta no válida de WordPress.');
            }
        } else {
            Log::warning('Cookies no encontradas en la solicitud.');
        }

        // Si no se puede autenticar, redirigir al formulario de inicio de sesión
        return redirect()->route('login')->withErrors([
            'login' => 'No se pudo autenticar con las cookies proporcionadas.',
        ]);
    }
}
