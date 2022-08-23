<?php

namespace App\Controllers;

use DateTime;
use App\Core\Db;
use App\Service\Cart;
use App\Models\DetailsModel;
use App\Models\ProduitsModel;
use App\Models\CommandesModel;
use App\Controllers\Controller;

class CartController extends Controller
{
   
    /**
     * Affiche le panier avec le total
     * @return void
     */

    public function panier()
    {
        // on instancie le new panier
        $cart = new Cart;
        $cart->creation();
       //on affiche le total du panier en utilisant function total() de la class Cart.php
        $total = $cart->total();
        //  echo "<pre>"; print_r($_SESSION['panier']); echo "</pre>";

        // render-> dans la route on met FUNCTION panier()=== à fichier panier.php dans dossier "cart" ed Views
        $this->render('cart/panier', compact('total'));
    }


    /**
     * Ajoute les articles dans le panier
     * @return void
     */
    public function ajouter($id)
    {
        // on declare le new panier
        $cart = new Cart;
        $cart->creation();

        //on affiche le total du panier en utilisant function total() de la class Cart.php
        $total = $cart->total();

        //on declare l'annonces par $id
        $produitsModel = new ProduitsModel;
        $p = $produitsModel->find($id);

         //si annonce n'est encore ajouté on entre dans condition pour ajouter nouveau produit
        if(!in_array("$id", $_SESSION['panier']['id_panier']))
       
        // on ajout dans le panier les valeurs de article, quantite qui est posté de tableau ,page "lire"
        $cart->ajouterProduit($p->id, $p->titre, $p->description, $p->stock,
        $_POST['quantite'], $p->prix );

        // echo "<pre>"; print_r($_SESSION['panier']); echo "</pre>";
        // var_dump($p);

        // render : dans la route on met FUNCTION ajouter() === à fichier ajouter.php dans dossier "cart"
        $this->render('cart/ajouter', compact('p', 'total'));

    }

    
    /**
     * Modifier le quantite des articles ajouter ou enlever
     * @return void
     */

    public function modifier($id)
    { 
        
        $cart = new Cart;
        $cart->creation();

        $produitsModel = new ProduitsModel;

        $id = $produitsModel->setId($id);
       

        //  echo "<pre>"; print_r($_SESSION['panier']); echo "</pre>";

        $cart->modifierQuantite($_POST['id_panier'], $_POST['quantite']);

        header('Location: '.$_SERVER['HTTP_REFERER']);

    }

    
    /**
     * Supression d'un article dans le panier
     * @return void
     */
    public function supprimer($id)
    { 
        
        $cart = new Cart;
        $cart->creation();

        $produitsModel = new ProduitsModel;
        $id =$produitsModel->setId($id);

        $id = $_SESSION['panier']['id_panier'];

        $cart->suppProduit($_GET['id_panier']);

        //  echo "<pre>"; print_r($_SESSION['panier']['id_panier']); echo "</pre>";


        header('Location: '.$_SERVER['HTTP_REFERER']);

    }

    
    /**
     * Supprision de pmanier "total"
     * @return void
     */

    public function delate()
    {
        
        $cart = new Cart;
        $cart->creation();

        $cart->supprimerPanier();

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }


    /**
     * Creation de commande
     */
    public function commande()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
             // on instancie le panier
            $cart = new Cart;
            $cart->creation();

        //creation de variable de BDD pour recuperer après notre "idLast"
            $db = Db::getInstance();

            //on instancie la commande
            $commande = new CommandesModel;
        
            // on déclare variable $date et sa valeure
            $date = date('Y-m-d H:i:s');

            
            // on insere les données dns commande
            $commande->setUser_id($_SESSION['user']['id'])
                    ->setMontant($cart->total())
                    ->setDate($date);

            // on enregistere commande
            $commande->create();

            //on trouve ID de derniere commande enregistrée dans BDD
            $idLast = $db->lastInsertId();

           // on convertie "string" $idlast  en "int"
            $id_com = (int) $idLast;

            $commande->setId_com($id_com);

            $_SESSION['id_com'] = $id_com;

            // echo "<pre>"; print_r($_SESSION['panier']); echo "</pre>";

            for($i = 0; $i < count($_SESSION['panier']['id_panier']); $i++)
            { 

            // echo "<pre>"; print_r($_SESSION['panier']['id_panier']); echo "</pre>";

                    // instancie l'annonces pour avoir accese au données de l'annonce à chaque tour de boucle
                    $produit = new ProduitsModel;

                    // on instancie $details pour crée les détails à chaque tour de boucle
                    $details = new DetailsModel;
                   
                    // var_dump($id_com);
                    
                    $details->setCom_id($id_com)
                            ->setProduit_id($_SESSION['panier']['id_panier'][$i])
                            ->setQuantite($_SESSION['panier']['quantite'][$i])
                            ->setPrix($_SESSION['panier']['prix'][$i]);
    
                    $details->create();

                    
                // on hydrate annonce , ou "id" corresponde à $_SESSION['panier']['id_panier'][$i]
                $produit->setId($_SESSION['panier']['id_panier'][$i])
                        ->setStock($_SESSION['panier']['stock'][$i] - $_SESSION['panier']['quantite'][$i]);
                
                // on enregister modification
                $produit->update();
            }

            // on supprime le panier après enregistrement
            $cart->supprimerPanier();
            
            $this->render('cart/commande', compact('commande'));  
        }
    }

   /**
    * afichage de commande enregistré
    */
    public function details()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
            
            //on instancie les détails de commande
            $detailsModel = new DetailsModel;
            
            
            $com_id = $_SESSION['id_com'];

            $details = $detailsModel->detailsCommande($com_id);

            // echo "<pre>"; print_r($details); echo "</pre>";

            $this->render('cart/details', compact('details'));

        }

    }






}