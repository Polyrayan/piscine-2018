<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';

    protected $fillable = ['mailClient','mdpClient','nomClient','prenomClient','telClient','sexeClient','dateNaissanceClient',
                         'adresseClient','codePostalClient','villeClient','idClient','produit1','produit2'];
    protected $hidden = ['mdpClient'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='mailClient';
    protected $keyType = 'string';


    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpClient;
    }

    /**
     * on overwrite la fonction car on ne se sert pas des remember token
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    //public function getAuthIdentifierName()
    //{
    //    return $this->mailClient;
    //}

    public static function getMailClient(){
        return Auth::guard('client')->user()->mailClient;
    }

    public static function getIdClient(){
        return Auth::guard('client')->user()->idClient;
    }

    public static function validateFormClient(){
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
    }

    public static function createClient(){
        return self::create([
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
    }

    public static function validateUpdate(){
        request()->validate([
            'name' => ['bail','required','string'],
            'firstName' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'zipCode' => ['bail','required','numeric'],
        ]);
    }

    public static function updateClient(){
        self::where('mailClient',request('mail'))
            ->update(['nomClient'=> request('name') ,
                'prenomClient'=> request('firstName'),
                'telClient' => request('phone'),
                'adresseClient' => request('address') ,
                'villeClient' => request('city'),
                'codePostalClient' => request('zipCode')
            ]);
    }

    public static function getMyAddress(){
        $client = self::where('mailClient',self::getMailClient())->first();
        return "$client->adresseClient , $client->villeClient ";
    }

    public static function getClientWithMail($mail){
        return self::where('mailClient',$mail)->firstOrFail();
    }

    public static function getClientWithId($id){
        return self::where('idClient',$id)->firstOrFail();
    }

    public static function getFirstProductToCompare(){
        return Auth::guard('client')->user()->produit1;
    }

    public static function getSecondProductToCompare(){
        return Auth::guard('client')->user()->produit2;
    }
    public static function product1And2IsEmpty(){
        $product1 = self::getFirstProductToCompare();
        $product2 = self::getSecondProductToCompare();
        if (empty($product1) and empty($product2)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function product1Or2IsEmpty(){
        $product1 = self::getFirstProductToCompare();
        $product2 = self::getSecondProductToCompare();
        if (empty($product1) or empty($product2)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function addAsProduct1($productNumber){
        return self::where('idClient',self::getIdClient())->update(['produit1'=> $productNumber]);
    }

    public static function addAsProduct2($productNumber){
        return self::where('idClient',self::getIdClient())->update(['produit2'=> $productNumber]);
    }

    public static function categoryOfNotEmptyProduct(){
        $product1 = self::getFirstProductToCompare();
        $product2 = self::getSecondProductToCompare();
        if (!empty($product1)){
            $firstProduct = Produit::productWithId($product1);
            return $firstProduct->nomTypeProduit;
        }
        if (!empty($product2)){
            $secondProduct = Produit::productWithId($product2);
            return $secondProduct->nomTypeProduit;
        }
    }

    public static function categoryOfProduct1(){
        $product1 = Auth::guard('client')->user()->produit1;
        $firstProduct = Produit::productWithId($product1);
        return $firstProduct->nomTypeProduit;
    }

    public static function categoryOfProduct2(){
        $product2 = Auth::guard('client')->user()->produit2;
        $secondProduct = Produit::productWithId($product2);
        return $secondProduct->nomTypeProduit;
    }

    public static function product1isEmpty(){
        $product1 = self::getFirstProductToCompare();
        if (empty($product1)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function product2isEmpty(){
        $product2 = self::getSecondProductToCompare();
        if (empty($product2)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function deleteProduct1(){
        return self::where('idClient',self::getIdClient())->update(['produit1'=> null]);
    }

    public static function deleteProduct2(){
        return self::where('idClient',self::getIdClient())->update(['produit2'=> null]);
    }

    public static function NoneEmptyProducts1And2(){
        $product1 = self::getFirstProductToCompare();
        $product2 = self::getSecondProductToCompare();
        if (!empty($product1) and !empty($product2)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function calculNumberOfProductToCompare(){
        $nb = 0;
        if (!empty(Auth::guard('client')->user()->produit1)){
            $nb++;
        }
        if (!empty(Auth::guard('client')->user()->produit2)){
            $nb++;
        }
        return $nb;

    }

    public static function isConnected(){
        if(Auth::guard('client')->check()){
            return true;
        }
        else{
            return false;
        }
    }

}
