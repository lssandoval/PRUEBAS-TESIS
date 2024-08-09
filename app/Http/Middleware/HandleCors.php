<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Fruitcake\Cors\HandleCors as Middleware;

class HandleCors extends Middleware
{
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], 200, [
                'Access-Control-Allow-Origin' => 'http://depintranet.cosede.gob.ec',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, X-CSRF-Token','X-WP-Nonce',
                'Access-Control-Allow-Credentials' => 'true',
            ]);
        }

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', 'http://depintranet.cosede.gob.ec');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-CSRF-Token','X-WP-Nonce');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
