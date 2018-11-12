<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        //return view('clientProfile');
        //var_dump(Auth::guard('client')->check());
        //var_dump(auth('seller')->check());
        return view('clientProfile');
        // var_dump(\Auth::check());

        //return auth('client')->user();


        /*if (auth('client')->check()){
            return 'client';
            //return view('clientProfile');
        }
        if(auth('seller')){
            return view('sellerProfile');
        }
        else{
            return redirect('/login')->withInput()->withErrors([
                "mailSeller" => "veuilez vous connecter",
            ]);
        }
        */
    }


}
