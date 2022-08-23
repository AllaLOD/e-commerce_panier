<?php

namespace App\Service;

use App\Models\ProduitsModel;

class Cart
{

    protected $cart;
    // protected $produits;

    
// creation de panier
    
public function creation()
{ 
    if(!isset($_SESSION['panier']))
    {
        $_SESSION['panier'] = [];
        $_SESSION['panier']['id_panier'] = array();
        $_SESSION['panier']['titre'] = [];
        $_SESSION['panier']['description'] = array();
        $_SESSION['panier']['image'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();

    }
         
}


 // ajout d'article dans le panier

public function ajouterProduit( $id, $titre, $description, $stock, $quantite, $prix)
{
        
            $positionProduit = array_search($id, $_SESSION['panier']['id_panier']);

            if($positionProduit !== false)
            {
                $_SESSION['panier']['quantite'][$positionProduit] += $quantite;

            }else{
                $_SESSION['panier']['id_panier'][] = $id;
                $_SESSION['panier']['titre'][] = $titre;
                $_SESSION['panier']['description'][] = $description;
                $_SESSION['panier']['stock'][] = $stock;
                $_SESSION['panier']['quantite'][] = $quantite;
                $_SESSION['panier']['prix'][] = $prix;
            }

            
        

}

// FONCTION MONTANT TOTAL PANIER
function total()
{
    
        $total = 0;
        // La boucle FOR tourne autant de fois qu'il y a d'id_panier dans la session, donc autant qu'il y a de produits dans le panier
        for($i = 0; $i < count($_SESSION['panier']['id_panier']); $i++)
        {
                        
            $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
            
        }
        return round($total, 2); // on arrondi le total à 2 chiffres après la vrigule
 
}

// modifier article de panier

public function modifierQuantite($id_panier,$quantite)
{
    if(isset($_SESSION['panier']))
    {
        $positionProduit = array_search($id_panier, $_SESSION['panier']['id_panier']);

    if ($positionProduit !== false) {
        $_SESSION['panier']['quantite'][$positionProduit] = $quantite;
    }


    }
}



    
// FUNCTION SUPPRESSION PRODUIT DANS PANIER
public function suppProduit($id_panier) // 29
{
    // On transmet à la fonction prédéfinie array_search(), l'id_panier du produit que on veut supprimer
    // array_search() retourne l'indice du tableau ARRAY auquel se trouve l'id_panier a supprimer
    //                                  29              ARRAY
    $positionProduit = array_search($id_panier, $_SESSION['panier']['id_panier']); // [0]

    // Si la valeur de $positionProduit est différente de FALSE, cela veut dire que l'id_panier a supprimer a bien été trouvé dans le panier de la session
    if(!empty($_SESSION['panier']['id_panier']))
    {
        // array_splice() permet de supprimer des éléments d'un tableau ARRAY
        // on supprime chaque ligne dans les tableaux ARRAY du produit en rupture de stock
        // array_splice() ré-organise les tbaleaux ARRAY, c'est à dire que tout les élément aux indices inférieur remonttent aux indices supérieurs, le produit stocké à l'indice 3 du teablau ARRAY remonte à l'indice 2 du tableau 
        array_splice($_SESSION['panier']['id_panier'], $positionProduit, 1); // [0]
        array_splice($_SESSION['panier']['titre'], $positionProduit, 1); 
        array_splice($_SESSION['panier']['description'], $positionProduit, 1); 
        array_splice($_SESSION['panier']['stock'], $positionProduit, 1);
        array_splice($_SESSION['panier']['prix'], $positionProduit, 1);  
        array_splice($_SESSION['panier']['quantite'], $positionProduit, 1); 
     
    }
}

// function de suppresion total

public function supprimerPanier()
{
    unset($_SESSION['panier']);
}


// detail complet de panier

// public function getFullCart():array
// {
//    $panier = [];

//     $panierData = [];

//     foreach($panier as $id_panier => $quantite)
//     {
//         $panierData[] = [
//             'annonce' => $this->$_SESSION['panier']['id_panier']->find($id_panier),
//             'quantite' => $quantite

//         ];
//     }

//     return $panierData;

// }









}