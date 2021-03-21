<?php

namespace App\Http\Middleware;

use JWTAuth;
use Closure;
use Illuminate\Http\Request;
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
    public function handle(Request $request, Closure $next)
    {
       try {
            if (empty(JWTAuth::getToken()))
            {
                return response()->json([
                        'status'  => 'error',
                        'message' => 'Authorization Token not found'
                    ]);
            } else {
                if (!JWTAuth::check()):
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Token expired'
                    ]);
                endif;
                    $user = JWTAuth::parseToken()->authenticate();
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Token is Invalid'
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Token is Expired'
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Authorization Token not found'
                ]);
            }
        }
        return $next($request);
    }
}
