<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LeaderCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (count($_SESSION) == 0){
            header("location:http://task.ac.cn");
            exit();
        }

        if ($_SESSION['role'] == 0){
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}