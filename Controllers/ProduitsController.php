<?php
namespace App\Controllers;

use App\Models\ProduitsModel;

class ProduitsController extends Controller
{
    /**
     * Methode d'affichage de produit de bdd
     * @return void
     */
    public function index()
    {
        // on instancie le model

        $produitsModel = new ProduitsModel;

        // on va chercher toutes les produit dans BDD

        $produits = $produitsModel->findAll();


        $this->render('produits/index', compact('produits'));
    }


    /**
     * Affichage de détails de produits
     * 
     */
    public function details(int $id)
    {
        // on instancie le model
        $produitsModel = new ProduitsModel;

        // on va chercher 1 produit par raport à ID
        $produit = $produitsModel->find($id);

        $this->render('produits/details', compact('produit'));
    }







}