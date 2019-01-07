<?php

namespace App\Http\Controllers;

use App\Admin;
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
use Illuminate\Http\Request;
use function Sodium\increment;



class ShopController extends Controller
{
    /*
     * @return a view with the shops of the seller and seller's mail
     */
    public function show()
    {
        $mailSeller = Vendeur::getSellerMail();
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $shops = Appartenir::shopsOfThisSeller($mailSeller);
        $orders = Commande::OrdersToTreat();
        $adminConnected = Admin::isConnected();
        return view('sellerShops', ['shops' => $shops, 'mailSeller' => $mailSeller , 'orders' => $orders, 'favoriteShop' => $favoriteShop , 'adminConnected' => $adminConnected]);
    }

    /*
     * @param : request of one of the forms created ( view sellerShops : shops buttons : [visit] and [quit]  , form to join a shop [join] or to create a shop [addStore]
     *                                                view myShop :  products buttons  : [show], [edit] and [delete]  , form to add a product [add]
     */
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('visit')) {
            return redirect(url()->current().'/'.request('siretNumber'));
        }
        elseif ($request->has('quit')) {
          $employés = Appartenir::sellersOfThisShop(request('siretNumber'))->count();
          if(request('mailSeller') == request('mailProprietaire') and $employés > 1){
            flash("Vous avez des employés, vous ne pouvez pas quiter votre commerce ! ")->success();
            return back();
           }
          else{
            return $this->quitShop(request('siretNumber'), request('mailSeller'));
          }
        }
        elseif ($request->has('join')) {
            return $this->joinShop(request('numShop'), request('codeShop'), request('mailSeller'));
        }
        elseif ($request->has('addStore')){
            return $this->applyAddForm();
        }
        elseif ($request->has('sales')) {
            return redirect(url()->current().'/'.request('siretNumber').'/ventes');
        }
        elseif ($request->has('favorite')) {
            Vendeur::updateMyFavoriteShop();
            return back();
        }

        elseif ($request->has('editCommerce')) {
          return redirect('/vendeur/commerces/modifier/'.request('siretNumber'));
          }
        // view myShop

        elseif ($request->has('add')) {
            return $this->addProduct();

        } elseif ($request->has('show')) {
            return redirect('/produits/'.request('product'));

        } elseif ($request->has('edit')) {
          if(request('variant') == null){
          return redirect('/vendeur/commerces/produit/'.request('variant'));
          }

          else{
            return redirect('/vendeur/commerces/produit/'.request('product'));

          }

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

        // post de la vue pour modifier un produit deja créé(bouton jaune)
        elseif ($request->has('editMyProduct')) {
            Produit::validateEditProduct();
            Produit::editProduct();
            flash("Modification du produit effectuée ! ")->success();
            return back();
        }

        // post de la vue pour modifier un commerce
        elseif ($request->has('Commerce')) {
            Commerce::validateEditCommerce();
            Commerce::editCommerce();
            flash("Modification du commerce effectuée ! ")->success();
            return back();
        }
        elseif ($request->has('ajouter')) {
            $appartenir = Appartenir::sellerAppartient(request('email'),request('siret'));
            if($appartenir){
              return back()->withInput()->withErrors(['appartenir' => "Le vendeur appartient déjà au commerce",]);
            }
            else{
              Appartenir::validateAppartenir();
              Appartenir::createAppartenir(request('siret'),request('email'));
              flash("Le vendeur a été ajouté au commerce ! ")->success();
              return back();
            }
        }
        elseif ($request->has('supprimer')) {
              Appartenir::deleteAppartenir(request('siret'),request('mail'));
              flash("Le vendeur a été supprimé du commerce ! ")->success();
              return back();
        }
        elseif ($request->has('new')) {
              Commerce::changeProp(request('changer'));
              flash("Le propriétaire a été changé ! ")->success();
              return redirect('/vendeur/commerces');
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
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $adminConnected = Admin::isConnected();
        return view('myShop', ['sellers' => $sellers, 'numShop' => $numSiretCommerce,
                    'shop' => $shop, 'products' => $products, 'types' => $types ,
                    'days' =>$days , 'schedulesOfWork' => $schedulesOfWork, 'groups' => $groups,
                    'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);
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
        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $shop = Commerce::shopWithSiret($numSiret);
        $days = Jour::all();
        $schedulesOfWork = Ouvrir::schedulesOfThisShop($numSiret);
        $sellers = Appartenir::sellersOfThisShop($numSiret);
        $products = Produit::productsOfThisShop($numSiret);
        return view('shop')->with(['sellers' => $sellers, 'numSiret' => $numSiret, 'shop' => $shop, 'products' => $products,
            'days' =>$days , 'schedulesOfWork' => $schedulesOfWork, 'mailClient' => $mailClient, 'id' => $id, 'nbCompare' => $nbCompare]);
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

    public function editProduct($id){

      $favoriteShop = Vendeur::getMyFavoriteShop();
      $adminConnected = Admin::isConnected();
      $product = Produit::productWithId($id);

      return view('editProduct', ['favoriteShop' => $favoriteShop , 'adminConnected' => $adminConnected, 'product' => $product]);
    }

    public function applyAddForm()
    {
        Commerce::validateFormShop();
        Commerce::createShop();
        Appartenir::createAppartenir(request('numSiret'), request('sellerMail'));
        return redirect('/vendeur/commerces');
    }

    public function editCommerce($siretNumber){

      $favoriteShop = Vendeur::getMyFavoriteShop();
      $adminConnected = Admin::isConnected();
      $shop = Commerce::shopWithSiret($siretNumber);
      $vendeurs = Appartenir::sellersOfThisShop($siretNumber);

      return view('editCommerce', ['favoriteShop' => $favoriteShop,'adminConnected' => $adminConnected, 'shop' => $shop, 'vendeurs' => $vendeurs]);
    }

}
