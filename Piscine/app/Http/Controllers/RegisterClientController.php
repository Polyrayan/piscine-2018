<?php

namespace App\Http\Controllers;

use App\Client;
use App\Vendeur;
use Illuminate\Http\Request;

class RegisterClientController extends Controller
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
        return view('registration.optionalSellerForm');
    }
    /**
     * données : choix du type d'utilisateur
     *
     * resultat : redirige selon le choix
     */

    public function findUser(Request $request)
    {
        switch ($request->input('action')) {
            case 'submitClient':
                return $this->applyClientForm();
                break;

            case 'submitSeller':
                return $this->applySellerForm();
                break;

        }
    }

    /**
     * données : choix du type d'utilisateur
     *
     * resultat : redirige selon le choix
     */

    public function findOption(Request $request)
    {
        switch ($request->input('action')) {
            case 'joinStore':
                return $this->applyClientForm();
                break;

            case 'addStore':
                return $this->applySellerForm();
                break;

        }
    }

    /**
     * check if there are no errors in the form if the form is ok the client
     * is saved in the Database then we give a success view for the new client
     */

    public function applyClientForm()
    {

        request()->validate([
          'mail' => ['bail','required','email'],
          'password' => ['bail','required','confirmed','min:6'],
          'password_confirmation' => ['required'],
          'name' => ['bail','required','string'],
          'firstName' => ['bail','required','string'],
          'address' => ['bail','required','string'],
          'city' => ['bail','required','string'],
          'postalCode' => ['bail','required','numeric'],
          'phone' => ['bail','required','numeric'],
          'gender' => ['bail','required','string'],
          'birthday' => ['bail','required','before:now'],
        ]);


        $client = Client::create([
          'mailClient' => request('mail'),
          'mdpClient' => bcrypt(request('password')),
          'nomClient' => request('name'),
          'prenomClient' => request('firstName'),
          'adresseClient' => request('address'),
          'villeClient' => request('city'),
          'telClient' => request('phone'),
          'codePostalClient' => request('postalCode'),
          'sexeClient' => request('gender'),
          'dateNaissanceClient' => request('birthday'),
        ]);

        return view('welcome');
    }

    /**
     * check if there are no errors in the form if the form is ok the seller is saved in
     * the Database then we give a optional view to add or join a Store for the new seller
     */

    public function applySellerForm()
    {

        request()->validate([
            'mailSeller' => ['bail','required','email'],
            'passwordSeller' => ['bail','required','min:6','required_with:password_confirmationSeller','same:password_confirmationSeller'],
            'password_confirmationSeller' => ['required'],
            'nameSeller' => ['bail','required','string'],
            'firstNameSeller' => ['bail','required','string'],
            'phoneSeller' => ['bail','required','numeric'],
        ]);


        $seller = Vendeur::create([
            'mailVendeur' => request('mailSeller'),
            'mdpVendeur' => bcrypt(request('passwordSeller')),
            'nomVendeur' => request('nameSeller'),
            'prenomVendeur' => request('firstNameSeller'),
            'telVendeur' => request('phoneSeller'),
        ]);

        return redirect('register/optionalForm')->with(compact('seller'));;
    }

    public function applyJoinForm()
    {
        request()->validate([
            'numSiret' => ['bail','required','min:14','max:14'],
            'recruitmentCode' => ['bail','required','min:6'],
        ]);
        return 0;
    }

    public function applyAddForm()
    {
        request()->validate([
            'numSiret' => ['bail','required','min:14','max:14'],
            'recruitmentCode' => ['bail','required','min:6'],
            'name' => ['bail','required','string'],
            'description' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'zipCode' => ['bail','required','numeric'],
            //
            //
            // todo : add the cssfile here and create a function to create products in this file
            //

        ]);

        $shop = Commerce::create([
            'numSiretCommerce' => request('numSiret'),
            'nomCommerce' => (request('name')),
            'libelleCommerce' => request('description'),
            'adresseCommerce' => request('address'),
            'villeCommerce' => request('city'),
            'telCommerce' => request('phone'),
            'codePostaCommercel' => request('zipCode'),
            'codeRecrutement' => request('recruitmentCode'),
        ]);
        // todo : add the seller to the shop

        return redirect('/');
    }
}