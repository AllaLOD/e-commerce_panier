<?php

namespace App\Models;

class DetailsModel extends Model
{

    protected $id_details;
    protected $com_id;
    protected $produit_id;
    protected $quantite;
    protected $prix;

    public function __construct()
    {
        $this->table = 'details';
    }


    
   //Methode qui reunisse 3 tables(commandes, details, produits) pour la commande viens d'enregistré

    public function detailsCommande($com_id)
    {
    $com_id = $_SESSION['id_com'];

     return $this->requete("SELECT * FROM commandes JOIN details ON commandes.id_com = details.com_id JOIN produits ON details.produit_id = produits.id AND com_id = $com_id")->fetchAll();
    }


   // Methode pour selectionner les details de une commande 

    public function commandesUser($id_com)
    {
       return $this->requete("SELECT * FROM commandes JOIN details ON commandes.id_com = details.com_id JOIN produits ON details.produit_id = produits.id AND id_com = $id_com")->fetchAll();
    
    }




    /**
     * Get the value of id_details
     */ 
    public function getId_details()
    {
        return $this->id_details;
    }

    /**
     * Set the value of id_details
     *
     * @return  self
     */ 
    public function setId_details($id_details)
    {
        $this->id_details = $id_details;

        return $this;
    }

    /**
     * Get the value of com_id
     */ 
    public function getCom_id()
    {
        return $this->com_id;
    }

    /**
     * Set the value of com_id
     *
     * @return  self
     */ 
    public function setCom_id($com_id)
    {
        $this->com_id = $com_id;

        return $this;
    }

    /**
     * Get the value of produit_id
     */ 
    public function getProduit_id()
    {
        return $this->produit_id;
    }

    /**
     * Set the value of produit_id
     *
     * @return  self
     */ 
    public function setProduit_id($produit_id)
    {
        $this->produit_id = $produit_id;

        return $this;
    }

    /**
     * Get the value of quantite
     */ 
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set the value of quantite
     *
     * @return  self
     */ 
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get the value of prix
     */ 
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */ 
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }
}