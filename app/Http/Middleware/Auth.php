<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use App\Models\User;
use App\Util\Response;
use Carbon\Carbon;

class Auth
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
        $decoded = JWT::decode($request->header('Authorization'), env('JWT_KEY'), ['HS256']);

        if(User::find($decoded->id)->email != $decoded->email ||
            (new Carbon($decoded->expireAt))->diffInDays(Carbon::now()) < 0)
        {
            return $this->unAuthorizedResponse();
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
