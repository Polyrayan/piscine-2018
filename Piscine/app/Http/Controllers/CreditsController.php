<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CreditsController extends Controller
{
    
    public function show(){
        return view('credits');
    }

}