<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Client;
use App\Commande;
use App\Commerce;
use App\Contenir;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Reservation;
use App\TypeProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Date\Date;
use phpDocumentor\Reflection\Types\Null_;
use function Sodium\increment;

class ShopController extends Controller
{
    /*
     * @return a view with the shops of the seller and seller's mail
     */
    public function show()
    {
        $mailSeller = 'vendeur@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = DB::table('appartenir')
            ->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')
            ->where('mailVendeur', $mailSeller)->get();
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
            return $this->joinShop(request('numShop'), request('codeShop'), request('mailSeller'));
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
            return $this->bookProduct(request('mailClient'),request('product'),request('quantity'));

        } elseif ($request->has('addShoppingCart')) {
            return $this->addToShoppingCart(request('mailClient'),request('product'),request('productPrice'),request('quantity'),request('numSiret'));

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
        $types = TypeProduit::select('nomTypeProduit','numTypeProduit')->get();
        return view('myShop', ['sellers' => $sellers, 'numShop' => $numSiretCommerce, 'shop' => $shop, 'products' => $products, 'types' => $types]);
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
            'numTypeProduit' => request('numType'),
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
        $idClient = $client->getIdClient();
        $shop = Commerce::where('numSiretCommerce', $numSiret)->firstOrFail(['nomCommerce']);
        $sellers = DB::table('appartenir')->join('vendeurs', 'appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce', $numSiret)
            ->get(['vendeurs.mailVendeur', 'vendeurs.nomVendeur', 'vendeurs.idVendeur']);

        $products = Produit::where('numSiretCommerce', $numSiret)->get();
        return view('shop')->with(['sellers' => $sellers, 'numSiret' => $numSiret, 'shop' => $shop, 'products' => $products, 'mailClient' => $mailClient, 'idClient' => $idClient]);
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
    /*
     * @param: the email of the client who wants to book, the product number and the quantity he wants to book
     * @return: create a new line in the table reservations and create a new line in the table contenir with parameters informations
     */
    public function bookProduct($mailClient,$numProduct,$quantity){
        request()->validate([
            'quantity' => ['bail', 'required', 'min:0' ,'max:99999']
        ]);
        $date =  Date::now()->format('Y-m-d H:i:s');// to get the french date ->format('d m y H:i:s');

        $reservation = Reservation::create([
            'dateReservation' => $date ,
            'mailClient' => $mailClient
        ]);

        Contenir::create([
            'numReservation' => $reservation->numReservation,
            'numProduit' => $numProduct,
            'qteReservation' => $quantity
        ]);

        DB::table('produits')->where('numProduit' , $numProduct)->decrement('qteStockDispoProduit', $quantity );

        return back();
    }

    /*
   * @param: the email of the client who wants to book, the product number the siret number of the product's shop and the quantity he wants to book
   * @return: create a new line in the table reservations and create a new line in the table contenir with parameters informations
   */
    public function addToShoppingCart($mailClient,$numProduct,$productPrice,$quantity,$numSiret){
        request()->validate([
            'quantity' => ['bail', 'required', 'min:0']
        ]);

        $panier = Panier::firstOrNew(['mailClient' => $mailClient , 'datePanier' => null]);

        if(is_null($panier->prixPanier)){
            $panier->prixPanier = $productPrice*$quantity;
        }else{
            $panier->prixPanier += $productPrice*$quantity;
        }
        $panier->save();

        $commande = Commande::firstOrNew(['numPanier' => $panier->numPanier , 'numSiretCommerce' => $numSiret , 'dateCommande' => null]);
        if(is_null($commande->prixCommande)){
            $commande->prixCommande = $productPrice*$quantity;
        }else{
            $commande->prixCommande += $productPrice*$quantity;
        }
        $commande->save();

        $detenir = Detenir::firstOrNew(['numCommande' => $commande->numCommande, 'numProduit'=> $numProduct]);
        if(is_null($detenir->qteCommande)){
            $detenir->qteCommande = $quantity;
        }else{
            $detenir->qteCommande += $quantity;
        }
        $detenir->save();

        return back();
    }
}