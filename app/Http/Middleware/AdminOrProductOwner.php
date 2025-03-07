<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminOrProductOwner
{
    public function handle(Request $request, Closure $next): Response
    {   
        $product = $request->route('product');

        if (Auth::user()->admin or Auth::user()->id == $product->user_id){
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
