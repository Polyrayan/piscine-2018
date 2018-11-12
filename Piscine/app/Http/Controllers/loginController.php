<?php

namespace App\Http\Controllers;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable; // inutile

class LoginController extends Controller
{

    use GuardHelpers;

    public function showForm()
    {
      return view('login');
    }

    public function findUser(Request $request)
    {
        switch ($request->input('action')) {
            case 'loginClient':
                return $this->applyClientForm();
                break;

            case 'loginSeller':
                return $this->applySellerForm();
                break;
        }
    }

    public function applyClientForm()
    {
      request()->validate([
        'mailClient' => ['required','email'],
        'passwordClient' => ['required'],
        ]);

      $login = Auth::guard('client')->attempt([
          'mailClient' => request('mailClient'),
          'password' => request('passwordClient')  // laravel va chercher le mdp en utilisant password et non mdpClient
        ]);

      if($login){
          $user = ['mailClient' => request('mailClient'),
          'mdpClient' => request('passwordClient') ];
          //dd(auth('client')->user());
          session()->put('test', 'toto');
           return redirect('/client/profil');
      }

      /**return back()->withInput()->withErrors([
        'mailClient' => "Email ou mot de passe incorrect",
          ]);
        */
       }

    public function applySellerForm()
    {
        request()->validate([
            'mailSeller' => ['required','email'],
            'passwordSeller' => ['required'],
        ]);

        $login = Auth::guard('seller')->attempt([
            'mailVendeur' => request('mailSeller'),
            'password' => request('passwordSeller') //// laravel va chercher le mdp en utilisant password et non mdpSeller
        ]);

        if($login){
            return redirect('/client/profil');  // todo : faire la vue
        }
        return back()->withInput()->withErrors([
            'mailSeller' => "Email ou mot de passe incorrect",
        ]);
    }
}
