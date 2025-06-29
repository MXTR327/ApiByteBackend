<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar tus ajustes para el intercambio de recursos de
    | origen cruzado (CORS). Esto determina qué operaciones de origen cruzado
    | pueden ejecutarse en navegadores web. Puedes ajustar estas configuraciones
    | según sea necesario.
    |
    | Para aprender más: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', '/*'], // Define los caminos que deben permitir CORS

    'allowed_methods' => ['*'], // Métodos HTTP permitidos (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['http://localhost:3000', 'http://localhost:8000'], // Dominios permitidos para hacer solicitudes

    'allowed_origins_patterns' => ['*localhost*'],


    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'X-CSRF-TOKEN',
        'X-Xsrf-Token',
        'Accept',
        'Origin',
        'Cache-Control',
        'Pragma'
    ],

    'exposed_headers' => ['Authorization'], // Encabezados expuestos (si es necesario)

    'max_age' => 0, // Tiempo de cache del preflight en segundos

    'supports_credentials' => true, // Si se permite el envío de cookies o credenciales
];
