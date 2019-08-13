<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accountCurrent = Auth::user()->account_type;
        if($accountCurrent == "admin" || $accountCurrent == "super-admin")
            return $next($request);
        else{
            return redirect()->route("admin.auth.login");
        }
    }
}
