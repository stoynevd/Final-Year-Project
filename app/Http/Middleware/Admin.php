<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    public function handle($request, Closure $next) {
        if(Auth::check()) {
            if(Auth::user()->rank == 'Admin') {
                return $next($request);
            }
            return redirect('/dashboard');
        }
        return redirect('/login');
    }
}
