<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Client;
use App\Commerce;
use App\Ouvrir;
use App\Reduction;
use App\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Jenssegers\Date\Date;
use Auth;

class RegisterController extends Controller
{
    /**
    * return the form to register the client/Seller
    */
    public function showForm()
    {
        return view('registration.registerForms');
    }

    /**
     * return the optional seller form to join or create his store
     */
    public function showOptionalForm()
    {
        if( session('seller')) {
            $seller = session('seller');
            return view('registration.optionalSellerForm')->with(['seller' => $seller]);
        }
        return view('registration.optionalSellerForm');
    }
    /**
     * données : choix du type d'utilisateur
     *
     * resultat : redirige selon le choix
     */

    public function findChoice(Request $request)
    {
        if ($request->has('submitClient')){
            return $this->applyClientForm();

        }elseif ($request->has('submitSeller')){
            return $this->applySellerForm();

        }elseif ($request->has('joinStore')) {
            return $this->applyJoinForm();

        }elseif ($request->has('addStore')){
            return $this->applyAddForm();
        }
    }

    /**
     * check if there are no errors in the form if the form is ok the client
     * is saved in the Database then we give a success view for the new client
     */

    public function applyClientForm()
    {
        if (Client::findClientMail(request('mail')) > 0 ){
            return back()->withErrors([
                'mail' => 'mail deja utilisé'
            ]);
        }
        Client::validateFormClient();
        Client::createClient();
        $login = Auth::guard('client')->attempt([
            'mailClient' => request('mail'),
            'password' => request('password')
        ]);
        Reduction::createClientReduction(request('mail'));
        return redirect('/');
    }

    /**
     * check if there are no errors in the form if the form is ok the seller is saved in
     * the Database then we give a optional view to add or join a Store for the new seller
     */

    public function applySellerForm()
    {
        if (Vendeur::findSellerMail(request('mailSeller')) > 0 ){
            return back()->withErrors([
                'mailSeller' => 'mail deja utilisé'
            ]);
        }
        Vendeur::validateFormSeller();
        Vendeur::createSeller();
        $seller = Vendeur::sellerWithThisMail(request('mailSeller'));
        $login = Auth::guard('seller')->attempt([
            'mailVendeur' => request('mailSeller'),
            'password' => request('passwordSeller') // laravel va chercher le mdp en utilisant password et non mdpSeller
        ]);
        flash('inscription réussie')->success();
        return redirect('/vendeur/commerces');
    }

    public function applyJoinForm()
    {
        Appartenir::validateFormAppartenir();
        $match = Commerce::matchSiretAndCode(request('numSiret'),request('joinCode'));
        if($match->count()>0)
        {
            Appartenir::createAppartenir(request('numSiret'), request('sellerMail'));
            return redirect('vendeur/commerces');
        }
            return back()->withErrors(["le numero SIRET et/ou le code est incorrect"]);
    }

    public function applyAddForm()
    {
        Commerce::validateFormShop();
        Commerce::createShop();
        Appartenir::createAppartenir(request('numSiret'), request('sellerMail'));
        return redirect('/vendeur/commerces');
    }
}
