<?php 

namespace App\Http\Controllers;

use Mail;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use App\Client;
use App\User;
use App\Contact;
use App\Vendeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    
    public function show() {
        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $adminConnected = Admin::isConnected();
        $favoriteShop = Vendeur::getMyFavoriteShop();
        return view('contact')->with(['adminConnected' => $adminConnected , 'favoriteShop' => $favoriteShop, 'user' => 'Seller' ]);
    }

    public function sendEmailMessage(Request $request) {
        /admin = Admin::all()->first();
        $adminMail = $admin->getAuthMail();

                $this->validate($request,
                    ['mail' => 'required',
                    'subject' => 'required',
                    'textMessage' => 'required']);

                Contact::create($request->all());

                Mail::send('email',
                    ['mail' => $request->get('mail'),
                    'textMessage' => $request->get('textMessage')],
                    function ($m) {
                        $m->from($request->get('mail'));
                        $m->to($adminMail)->subject($request->get('subject'));
                    }
                );
        flash("Merci pour votre message!")->success();
        return back();
    }

}