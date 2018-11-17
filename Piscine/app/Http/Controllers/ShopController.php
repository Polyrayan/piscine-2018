<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Client;
use App\Commerce;
use App\Contenir;
use App\Produit;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Date\Date;

class ShopController extends Controller
{
    /*
     * @return a view with the shops of the seller and seller's mail
     */
    public function show()
    {
        $mailSeller = 'vendeur@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $mailSeller)->get();

        return view('sellerShops', ['shops' => $shops, 'mailSeller' => $mailSeller]);
    }

    /*
     * @param : request of one of the forms created ( view sellerShops : shops buttons : [visit] and [quit]  , form to join a shop [join]
     *                                                view myShop :  products buttons  : [show], [edit] and [delete]  , form to add a product [add]
     */
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('visit')) {
            $numSiret = request('visit');
            return $this->myShop($numSiret);

        } elseif ($request->has('quit')) {
            $numSiret = request('quit');
            $mailSeller = request('mailSeller');
            // todo supprimer dans la table appartenir

        } elseif ($request->has('join')) {
            $numSiret = request('numShop');
            $codeShop = request('codeShop');
            $mailSeller = request('mailSeller');
            return $this->joinShop($numSiret, $codeShop, $mailSeller);
        }

        // view myShop

        elseif ($request->has('add')) {
            return $this->addProduct();

        } elseif ($request->has('show')) {
            return 'a faire';

        } elseif ($request->has('edit')) {
            return 'a faire';

        } elseif ($request->has('delete')) {
            return 'a faire';

            // view shop

        } elseif ($request->has('book')) {
            $mailClient = request('mailClient');
            $numProduct = request('product');
            $quantity = request('quantity');

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0']
            ]);
            $date =  Date::now()->format('Y-m-d H:i:s');//->format('d m y H:i:s');
            //return $date;
            $reservation = Reservation::create([
                'dateReservation' => $date ,'mailClient' => $mailClient

            ]);

            Contenir::create([
                'numreservation' => $reservation->id,
                'numProduit' => $numProduct,
                'qteReservation' => $quantity
            ]);

            return back();

        } elseif ($request->has('addShoppingCart')) {
            return 'panier';

        } else {
            return 'boulette';
        }

    }

    /*
     * @param : numSiret
     * @return : view to edit the shop with the shop informations, the siret number and the products of this shop
     */
    public function myShop($numSiretCommerce)
    {
        $shop = Commerce::where('numSiretCommerce', $numSiretCommerce)->firstOrFail();
        $sellers = DB::table('appartenir')->join('vendeurs', 'appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce', $numSiretCommerce)
            ->get(['vendeurs.mailVendeur', 'vendeurs.nomVendeur', 'vendeurs.idVendeur']);
        $products = Produit::where('numSiretCommerce', $numSiretCommerce)->get();
        return view('myShop', ['sellers' => $sellers, 'numShop' => $numSiretCommerce, 'shop' => $shop, 'products' => $products]);
    }

    /*
     *  @param : use the information to the form in the view named "myShop"
     *  @return : if informations are validate it will create the product in the database with the hidden $numShop value in the form
     */
    public function addProduct()
    {
        request()->validate([
            'productName' => ['bail', 'required'],
            'description' => ['bail', 'required'],
            'stock' => ['bail', 'required', 'int'],
            'delivery' => ['bail', 'required'],
            'price' => ['bail', 'required', 'numeric'],
        ]);

        $product = Produit::create([
            'nomProduit' => request('productName'),
            'libelleProduit' => request('description'),
            'qteStockProduit' => request('stock'),
            'qteStockDispoProduit' => request('stock'),
            'livraisonProduit' => request('delivery'),
            'prixProduit' => request('price'),
            'numSiretCommerce' => request('numSiretCommerce')
        ]);
        return back();
    }

    /*
     * @param : a siret number
     * @return : the view which have this siret number
     */
    public function numSiret($numSiret)
    {

        $client = new Client();
        $mailClient = $client->getMailClient();
        $shop = Commerce::where('numSiretCommerce', $numSiret)->firstOrFail(['nomCommerce']);
        $sellers = DB::table('appartenir')->join('vendeurs', 'appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce', $numSiret)
            ->get(['vendeurs.mailVendeur', 'vendeurs.nomVendeur', 'vendeurs.idVendeur']);
        $products = Produit::where('numSiretCommerce', $numSiret)->get();
        return view('shop')->with(['sellers' => $sellers, 'numSiret' => $numSiret, 'shop' => $shop, 'products' => $products, 'mailClient' => $mailClient]);
    }

    /*
     * @param : a siret number , a code for join the shop and the seller's mail who wants to join
     * @return : create the link between this seller and this siret number if it's the correct code else return an error
     */
    public function joinShop($numSiret, $codeShop, $mailSeller)
    {
        if (Commerce::where('numSiretCommerce', $numSiret)->where('codeRecrutement', $codeShop)->first()) {
            Appartenir::create([
                'numSiretCommerce' => $numSiret,
                'mailVendeur' => $mailSeller,
            ]);
            return back();
        } else {
            return back()->withErrors([
                'join' => "le numéro Siret ou le code est incorrect",
            ]);
        }
    }
}