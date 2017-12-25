<?php

namespace App\Http\Middleware;

use App\Api\Helpers\Api\ApiResponse;
use Closure;

class CheckAccessToken
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->accessToken($request)){
            return $this->accessToken($request);
        }

        return $next($request);
    }
}
