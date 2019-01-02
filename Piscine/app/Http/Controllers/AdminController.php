<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use App\TypeProduit;

class AdminController extends Controller
{
    public function show(){
        $categories = TypeProduit::all();
        return view('admin.admin', ['categories' => $categories]);
    }
    public function selectForm(Request $request)
    {
        if ($request->has('add')) {

            TypeProduit::createCategorie();
            return back();

        } elseif ($request->has('modifier')) {

            TypeProduit::changeCategorie();
            return back();

        } elseif ($request->has('delete')) {

            TypeProduit::deleteCategorie();
            return back();

        } elseif ($request->has('connect')) {

            if(Admin::validateMail()>0){
                Admin::updateSellerFollowed();
                return redirect('/vendeur/commerces');
            } else{
                return back()->withErrors([
                    'connect' => "ce mail n'existe pas ou n'est pas celui d'un vendeur",
                ]);
            }
        }
    }
}