<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $userType): Response
    // {
    //     if(auth()->user()->type == $userType){
    //         return $next($request);
    //     }

    //     return response()->json(['Vous n\'avez pas l\'autorisation d\'accéder à cette page.']);
    // }

    public function handle(Request $request, Closure $next, $userType): Response
    {
        if (auth()->user()->type == $userType) {
            return $next($request);
        }
    
        return response()->json(['error' => 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.'], 403)
            ->header('X-Alert', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
    }

}
