<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSSO
{
    public function handle($request, Closure $next)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $username = $validated['username'];
        $password = $validated['password'];

        if ($username && $password) {
            $credentials = [
                'samaccountname' => $username,
                'password' => $password,
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard');
            }
        }

        return $next($request);
    }
}
