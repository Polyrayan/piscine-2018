<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:client')->except('logout');
        $this->middleware('guest:seller')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showForm()
    {
        return view('registration.login');
    }

    public function showAdminForm()
    {
        return view('registration.loginAdmin');
    }

    public function selectForm(Request $request)
    {
        if ($request->has('loginClient')){
            return $this->applyClientForm();
        }
        elseif ($request->has('loginSeller')){
            return $this->applySellerForm();
        }
        elseif ($request->has('loginAdmin')){
            return $this->applyAdminForm();
        }
    }

    public function applyClientForm()
    {
        $login = Auth::guard('client')->attempt([
            'mailClient' => request('mailClient'),
            'password' => request('passwordClient')
        ]);

        if($login){
            return redirect('/client/profil');
        }
        return back()->withInput()->withErrors(['mailClient' => "Email ou mot de passe incorrect",]);
    }

    public function applySellerForm()
    {
        request()->validate([
            'mailSeller' => ['required','email'],
            'passwordSeller' => ['required'],
        ]);

        $login = Auth::guard('seller')->attempt([
            'mailVendeur' => request('mailSeller'),
            'password' => request('passwordSeller') // laravel va chercher le mdp en utilisant password et non mdpSeller
        ]);

        if($login){
            return redirect('/vendeur/commerces');
        }
        return back()->withErrors([
            'mailSeller' => "Email ou mot de passe incorrect",
        ]);
    }

    public function applyAdminForm()
    {
        request()->validate([
            'mailAdmin' => ['required','email'],
            'passwordAdmin' => ['required'],
        ]);

        $login = Auth::guard('admin')->attempt([
            'mailAdmin' => request('mailAdmin'),
            'password' => request('passwordAdmin')
        ]);

        if($login){
            return redirect('/admin');
        }

        return back()->withErrors([
            'mailAdmin' => "Email ou mot de passe incorrect",
        ]);
    }

    public function deconnexion(){
        auth()->logout();
    }
}
