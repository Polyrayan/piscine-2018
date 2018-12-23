<?php

namespace App\Http\Controllers;
use App\TypeProduit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function show(){
    $categories = TypeProduit::all();
    return view('admin', ['categories' => $categories]);
  }
  public function selectForm(Request $request){
    if ($request->has('add')) {
      TypeProduit::createCategorie();
      return back();
    }
    elseif ($request->has('modifier')){
      TypeProduit::changeCategorie();
      return back();
    }
    elseif ($request->has('delete')){
      TypeProduit::deleteCategorie();
      return back();
    }
  }
}
