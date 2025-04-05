<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\JwtTokenException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user){
                throw new JwtTokenException('user not found', 404);
            }
            
            $request->merge(['user' => auth('api')->user()]);
        }  catch (JWTException $e) {
            if ($e instanceof TokenInvalidException){
                throw new JwtTokenException('invalid token', 403);
            }else if ($e instanceof TokenExpiredException){
                throw new JwtTokenException('token expired', 403);
            }else{
                throw new JwtTokenException('token not found', 401);
            }
        }

        return $next($request);
    }
}
