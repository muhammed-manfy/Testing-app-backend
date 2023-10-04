<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $token = $request->header('token');
            $payLoad = JWTAuth::setToken($token)->getPayload()->toArray();
        }
        catch(TokenExpiredException $error){
            return response()->json(['Token Expired'],500);
        }
        catch(TokenInvalidException $error){
            return response()->json(['Token Invalid'],500);
        }
        catch(JWTException $error){
            return response()->json(['message'=>$error->getMessage()],
            500 ) ;
        }
        return $next($request);
    }
}
