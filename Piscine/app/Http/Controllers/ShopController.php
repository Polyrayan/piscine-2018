<?php

namespace App\Http\Controllers;

use App\Commerce;
use App\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ShopController extends Controller
{
    public function show()
    {
        $mailSeller = 'vendeur@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $mailSeller)->get();

        return view('sellerShops', ['shops' => $shops, 'mailSeller' => $mailSeller]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('visit')) {
            $numShop = request('visit');
            return Redirect::to('vendeur/commerces/' . $numShop);

        } elseif ($request->has('quit')) {
            $numShop = request('quit');
            $mailSeller = request('mailSeller');
            // todo supprimer dans la table appartenir

        } elseif ($request->has('join')) {
            // todo :  vérifier que le nom et le code sont vrais
            return request('nameShop');
        }

        //view myShop

         elseif ($request->has('add')) {
            return $this->addProduct();

        } elseif ($request->has('show')) {
            return 'a faire';

        } elseif ($request->has('edit')) {
            return 'a faire';

        } elseif ($request->has('delete')) {
            return 'a faire';
        }

    }

    public function numSiret($numSiretCommerce)
    {
        $shopName = Commerce::where('numSiretCommerce', $numSiretCommerce)->firstOrFail();
        $sellers = DB::table('appartenir')->join('vendeurs', 'appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce', $numSiretCommerce)->get(['vendeurs.mailVendeur', 'vendeurs.nomVendeur']);
        $products = DB::table('produits')->where('numSiretCommerce', $numSiretCommerce)->get();
        return view('myShop', ['sellers' => $sellers, 'numShop' => $numSiretCommerce, 'shopName' => $shopName, 'products' => $products]);
    }


    public function addProduct()
    {
        request()->validate([
            'productName' => ['bail' ,'required'],
            'description' => ['bail','required'],
            'stock'       => ['bail','required','int'],
            'delivery'    => ['bail','required'],
            'price'       => ['bail','required','numeric'],
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

}