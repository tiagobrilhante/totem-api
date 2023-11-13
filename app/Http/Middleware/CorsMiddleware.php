<?php

/**
 * Location: /app/Http/Middleware
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, PATCH, GET, OPTIONS, PUT, DELETE', 'HEAD', 'CONNECT', 'TRACE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            //'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
            //'Access-Control-Allow-Headers'     => 'Origin, X-Requested-With,Authorization,Content-Type'
            'Access-Control-Allow-Headers' => '*',
            'Access-Control-Expose-Headers'=> '*',
            'Access-Control-Request-Method'=>'*',
            'Access-Control-Request-Headers'=>'*'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
