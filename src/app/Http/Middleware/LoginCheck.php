<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	var_dump($_SESSION['role']);die();
    	
        if ($request->input('age')<18){
            return redirect()->route('user.test');
        }
        return $next($request);
    }
}
