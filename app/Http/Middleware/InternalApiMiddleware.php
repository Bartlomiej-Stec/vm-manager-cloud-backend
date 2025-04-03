<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\InternalApiAccessException;
use App\Models\InternalToken;
use Symfony\Component\HttpFoundation\Response;

class InternalApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw new InternalApiAccessException('Unauthorized', 401);
        }

        $internalToken = InternalToken::where('token', $token)->first();
        if(!$internalToken){
            throw new InternalApiAccessException('Access denied', 403);
        }
        if($internalToken->created_at->diffInMinutes(now()) > config('internal_api.expiration_time')){
            $internalToken->delete();
            throw new InternalApiAccessException('Token expired', 401);
        }
        $internalToken->delete();
        return $next($request);
    }
}
