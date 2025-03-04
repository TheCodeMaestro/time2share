<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth::user()->admin){
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
