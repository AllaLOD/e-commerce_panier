<?php
namespace App\Models;


class CommandesModel extends Model
{
    protected $id_com;
    protected $user_id;
    protected $montant;
    protected $date;

    public function __construct()
    {
        $this->table = 'commandes';
    } 
     
    

    /**
     * Get the value of id_com
     */ 
    public function getId_com()
    {
        return $this->id_com;
    }

    /**
     * Set the value of id_com
     *
     * @return  self
     */ 
    public function setId_com($id_com)
    {
        $this->id_com = $id_com;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of montant
     */ 
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */ 
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }



   

}