<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Client
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
        if(!Auth::guard('client')->check()){
            flash("Vous devez être connecté en tant que <b> client </b> pour accéder à cette page")->error();
            return redirect('/login');
        }
        return $next($request);
    }
}
