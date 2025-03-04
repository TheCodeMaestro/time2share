<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBlocked
{
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth::user()->blocked){
            //laat de user dan returnen naar een pagina waarin staat dat hij geblocked is
            // Moet blocked pagina nog maken
            return $next($request);
        }
        return $next($request);
    }
}
