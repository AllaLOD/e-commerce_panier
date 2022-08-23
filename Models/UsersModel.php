<?php 

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $civilite;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $roles;

    public function __construct()
    {
        // $this->table = 'users';
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);

        $this->table = strtolower(str_replace('Model', '', $class));
    }

 

    /**
     * Récuper un user à partir son email
     * @param string $email
     * @return mixed
     */

    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email = ?", [$email])->fetch();
    }


    /**
     * Crée la Session de l'utilisateur
     * @return void
     */
    public function setSession(){
        $_SESSION['user'] = [
            'id' => $this->id,
            'civilite' => $this->civilite,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }
    
    /**
     * Selection d'utilisateur par ID de commande
     */
    public function userCommande($id_com)
    {
        return $this->requete("SELECT * FROM users JOIN commandes ON users.id = commandes.user_id AND id_com = $id_com ");
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of civilite
     */ 
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set the value of civilite
     *
     * @return  self
     */ 
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles():array
    {
        $roles = $this->roles;
        $roles[] = ['ROLE_ADMIN', 'ROLE_USER'];
                    

        // on utilise function pour netoyer notre tableau, pas avoir de dublon de roles
        return array_unique($roles);  
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = json_decode($roles);

        return $this;
    }

    
}
