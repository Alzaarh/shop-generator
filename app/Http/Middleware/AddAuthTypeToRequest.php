<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class AddAuthTypeToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action
        $request->merge(['authType' => DB::table('auth_type')
            ->select('auth_type')
            ->get()
            ->first()
            ->auth_type
        ]);

        $response = $next($request);

        // Post-Middleware Action
        return $response;
    }
}
