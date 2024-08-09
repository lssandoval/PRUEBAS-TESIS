<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of origins that are allowed to make
    | requests to your application. You can set this to '*' to allow
    | any origin or you can specify individual origins.
    |
    */

    'allowed_origins' => ['http://depintranet.cosede.gob.ec'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of HTTP methods that are allowed when
    | making a request to your application. You can set this to '*' to
    | allow all methods.
    |
    */

    /*
     * Path patterns for which CORS should be enabled.
     */
    'paths' => ['api/*', 'sso-login'], // Incluye tus rutas aquí
    /*
     * List of HTTP methods that are allowed.
     */

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of headers that are allowed when
    | making a request to your application. You can set this to '*' to
    | allow all headers.
    |
    */

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'X-CSRF-Token'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of headers that are exposed when
    | making a request to your application. You can set this to '*' to
    | expose all headers.
    |
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Here you may specify the maximum number of seconds that the results
    | of a preflight request can be cached by clients.
    |
    */

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | This option determines whether the application supports credentials
    | in CORS requests.
    |
    */

    'supports_credentials' => true,

];


