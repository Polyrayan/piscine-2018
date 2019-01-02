<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Vendeur
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
        if(!Auth::guard('seller')->check() and !Auth::guard('admin')){
            flash("Vous devez être connecté en tant que <b> vendeur </b> pour accéder à cette page")->error();
            return redirect('/login');
        }
        return $next($request);
    }
}
