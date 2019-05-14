<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Lecturer
{
    public function handle($request, Closure $next) {
        if(Auth::check()) {
            if(Auth::user()->rank == 'Lecturer') {
                return $next($request);
            }
            return redirect('/admin');
        }
        return redirect('/login');
    }
}
