<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            // this for using default laravel user auth 
            // change if you need custom auth table
            $user = JWTAuth::parseToken()->authenticate();
          } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
              return response()->json(['status' => 'TOKEN_IS_INVALID'],500);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
              return response()->json(['status' => 'TOKEN_IS_EXPIRED',500]);
            } else {
              return response()->json(['status' => 'TOKEN_NOT_FOUND',500]);
            }
          }
        return $next($request);
    }
}
