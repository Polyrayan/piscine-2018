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
        if(!Auth::guard('admin')->check()){
            flash("Vous devez être connecté en tant qu' <b> administateur  </b> pour accéder à cette page")->error();
            return redirect('/login/admin');
        }
        return $next($request);
    }
}
