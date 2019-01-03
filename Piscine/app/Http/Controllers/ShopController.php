<?php

namespace App\Http\Controllers;

use App\Jour;
use App\Vendeur;
use App\Client;
use App\Ouvrir;
use App\Panier;
use App\Produit;
use App\Detenir;
use App\Contenir;
use App\Commande;
use App\Commerce;
use App\Appartenir;
use App\TypeProduit;
use App\Reservation;
use App\Variante;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use function Sodium\increment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;


class ShopController extends Controller
{
    /*
     * @return a view with the shops of the seller and seller's mail
     */
    public function show()
    {
        $mailSeller = Vendeur::getSellerMail(); // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = Appartenir::shopsOfThisSeller($mailSeller);
        $orders = Commande::OrdersToTreat();
        return view('sellerShops', ['shops' => $shops, 'mailSeller' => $mailSeller , 'orders' => $orders]);
    }

    /*
     * @param : request of one of the forms created ( view sellerShops : shops buttons : [visit] and [quit]  , form to join a shop [join]
     *                                                view myShop :  products buttons  : [show], [edit] and [delete]  , form to add a product [add]
     */
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('visit')) {
            return redirect(url()->current().'/'.request('siretNumber'));
        }
        elseif ($request->has('quit')) {
            return $this->quitShop(request('siretNumber'), request('mailSeller'));
        }
        elseif ($request->has('join')) {
            return $this->joinShop(request('numShop'), request('codeShop'), request('mailSeller'));
        }
        elseif ($request->has('sales')) {
            return redirect(url()->current().'/'.request('siretNumber').'/ventes');
        }

        // view myShop

        elseif ($request->has('add')) {
            return $this->addProduct();

        } elseif ($request->has('show')) {
            return redirect('/produits/'.request('product'));

        } elseif ($request->has('edit')) {
            return 'a faire';

        } elseif ($request->has('variant')) {
            $variant = Produit::productWithId(request('product'));
            return redirect(url()->current().'/variante/'.$variant->numGroupeVariante);

        } elseif ($request->has('delete')) {
            Produit::deleteProduct(request('product'));
            return back();

            // view shop

        } elseif ($request->has('book')) {
            return $this->bookProduct(request('mailClient'),request('product'),request('quantity'));

        } elseif ($request->has('addShoppingCart')) {
            return $this->addToShoppingCart(request('mailClient'),request('product'),request('productPrice'),request('quantity'),request('numSiret'));

        }
    }

    /*
     * @param : numSiret
     * @return : view to edit the shop with the shop informations, the siret number and the products of this shop
     */
    public function myShop($numSiretCommerce)
    {
        $shop = Commerce::shopWithSiret($numSiretCommerce);
        $sellers = Appartenir::sellersOfThisShop($numSiretCommerce);
        $products = Produit::productsOfThisShopGroupedByVariant($numSiretCommerce);
        $groups = Produit::allVariants($numSiretCommerce);
        $types = TypeProduit::all();
        $days = Jour::all();
        $schedulesOfWork = Ouvrir::schedulesOfThisShop($numSiretCommerce);
        return view('myShop', ['sellers' => $sellers, 'numShop' => $numSiretCommerce,
                    'shop' => $shop, 'products' => $products, 'types' => $types ,
                    'days' =>$days , 'schedulesOfWork' => $schedulesOfWork, 'groups' => $groups]);
    }

    /*
     *  @param : use the information to the form in the view named "myShop"
     *  @return : if informations are validate it will create the product in the database with the hidden $numShop value in the form
     */
    public function addProduct()
    {
        $newGroupVariant = Variante::createVariant();
        Produit::validateProduct();
        Produit::createProduct($newGroupVariant->numGroupeVariante);
        return back();
    }

    /*
     * @param : a siret number
     * @return : the view which have this siret number
     */
    public function numSiret($numSiret)
    {
        $mailClient = Client::getMailClient();
        $idClient = Client::getIdClient();
        $shop = Commerce::nameOfThisShop($numSiret);
        $sellers = Appartenir::sellersOfThisShop($numSiret);
        $products = Produit::productsOfThisShop($numSiret);
        return view('shop')->with(['sellers' => $sellers, 'numSiret' => $numSiret, 'shop' => $shop, 'products' => $products, 'mailClient' => $mailClient, 'idClient' => $idClient]);
    }

    /*
     * @param : a siret number , a code for join the shop and the seller's mail who wants to join
     * @return : create the link between this seller and this siret number if it's the correct code else return an error
     */
    public function joinShop($numSiret, $codeShop, $mailSeller)
    {
        if (Commerce::where('numSiretCommerce', $numSiret)->where('codeRecrutement', $codeShop)->first()) {
            Appartenir::createAppartenir($numSiret,$mailSeller);
            return back();
        }
        else {
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
        $reservation = Reservation::createReservation($mailClient);
        Contenir::createContenir($reservation,$numProduct,$quantity);
        Produit::decrementProduct($numProduct,$quantity);
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
        $panier = Panier::firstOrNewPanier($mailClient);
        Panier::addPriceToThisShoppingCart($panier,$productPrice,$quantity);

        $commande = Commande::firstOrNewCommande($panier,$numSiret);
        Commande::addPriceToThisOrder($commande,$productPrice,$quantity);

        $detenir = Detenir::firstOrNewDetenir($commande,$numProduct);
        Detenir::storeQuantity($detenir,$quantity);

        return back();
    }

    public function quitShop($siretNumber,$mailSeller){
        $appartenir = Appartenir::where("numSiretCommerce",$siretNumber)->where("mailVendeur",$mailSeller)->firstOrFail();
        $appartenir->delete();
        return back();
    }

}