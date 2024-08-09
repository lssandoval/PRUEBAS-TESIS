<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Generar el código de seguridad
        $pin_seg001 = substr(md5(uniqid(rand())), 0, 7);

        session(['pin_seg001' => $pin_seg001]); // Guardar en la sesión

        // Pasar el código a la vista
        return view('auth.login', ['pin_seg001' => $pin_seg001]);
    }

    public function login(Request $request)
    {
        // Validar el formulario incluyendo el código de seguridad
        $request->validate([
            Fortify::username() => 'required|string',
            'password' => 'required|string',
            'password_seg_input' => 'required|string',
        ]);

        // Verificar el código de seguridad
        if ($request->input('password_seg_input') !== session('pin_seg001')) {
            return back()->withErrors([
                'password_seg_input' => 'El código de seguridad es incorrecto.',
            ]);
        }

        // Proceder con la autenticación por formulario
        $credentials = [
            'samaccountname' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user(); // Obtener el usuario autenticado

            // Verificar si el usuario tiene roles
            if ($user->roles->isEmpty()) {
                // Redirigir al usuario a una página de acceso denegado si no tiene roles
                return redirect()->route('no-access');
            }

            return app(LoginResponse::class);
        }

        // Si las credenciales son incorrectas, regresar con un error
        return back()->withErrors([
            Fortify::username() => trans('auth.failed'),
        ]);
    }

    protected function getUsernameFromToken($token)
    {
        $decoded = base64_decode($token);
        list($perUsuario) = explode(':', $decoded);
        return $perUsuario;
    }

    protected function createUser($perUsuario, $persona)
    {
        // Implementar la lógica para crear un nuevo usuario
        return User::create([
            'guid' => $this->generateGUID(),
            'domain' => 'default',
            'password' => bcrypt('default_password'), // Puedes establecer una contraseña por defecto o algún otro método de autenticación
            'name' => $persona->per_nombre, // Asigna el nombre de la persona al nuevo usuario
            'username' => $perUsuario,
        ]);
    }

    protected function generateGUID()
    {
        return \Illuminate\Support\Str::uuid()->toString();
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cerrar sesión del usuario

        // Invalidar la sesión y regenerar el token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la página de inicio o a una URL especificada
        $redirectUrl = $request->input('redirect', '/login');
        return redirect($redirectUrl);
    }
}
