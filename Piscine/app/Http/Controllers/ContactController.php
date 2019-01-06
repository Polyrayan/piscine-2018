<?php 

namespace App\Http\Controllers;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{

    protected $redirectTo = '/welcome';
    
    public function show(){
        return view('contact');
    }

    public function sendEmailMessage(Request $request, $id) {
        Mail::send('emails.messages');
    }
}