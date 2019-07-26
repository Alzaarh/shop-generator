<?php

namespace App\Http\Middleware;

use Closure;
use App\Util\Response;

class IsGuest
{
    use Response;
    
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
        if($request->header('Authorization'))
        {
            return $this->forbiddenResponse();
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
