<?php

namespace App\Http\Controllers;

use app\Client;

class RegisterClientController extends Controller
{
    /**
    * return the form to register for a CLient
    */
    public function showForm()
    {
        return view('registerForms');
    }

    /**
    * check if there are no errors in the form
    * if the form is ok the client is saved in the Database
    * then we give a success view for the new client
    */
    public function applyForm()
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

        return "Formulaire reçu Mr " . request('name');
    }
}
