<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{

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

      $login = auth('client')->attempt([
          'mailClient' => request('mailClient'),
          'password' => request('passwordClient')  // laravel va chercher le mdp en utilisant password et non mdpClient
        ]);

      if($login){
          return redirect('/client/profil');
      }
      return back()->withInput()->withErrors([
        'mailClient' => "Email ou mot de passe incorrect",
          ]);
    }

    public function applySellerForm()
    {
        request()->validate([
            'mailSeller' => ['required','email'],
            'passwordSeller' => ['required'],
        ]);

        $login = auth('seller')->attempt([
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
