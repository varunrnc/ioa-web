<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if(strtolower(auth()->user()->type) == 'admin'){
            return $next($request);
        }
        return abort(403,'Access Denied');
    }
}
