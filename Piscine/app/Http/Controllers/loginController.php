<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    public function showForm()
    {
      return view('login');
    }

    public function applyForm()
    {
      request()->validate([
        'mail' => ['bail','required','email'],
        'password' => ['bail','required','confirmed','min:6'],
      ]);
      
    }
}
