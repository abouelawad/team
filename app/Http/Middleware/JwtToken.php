<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Traits\ApiDesignTrait;

class JwtToken
{
    use ApiDesignTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException ) {
                
                return $this->apiResponse(422 , 'token expired');
            }elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException  ) {
                return $this->apiResponse(422, 'token invalid');
                
            }else{
                return $this->apiResponse(404 , 'token not found');
            }
        }

        return $next($request);
    }
}
