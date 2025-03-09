<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsBlocked
{
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth::user()->blocked)
        {
            return redirect('blocked');
        }
        return $next($request);
    }
}
