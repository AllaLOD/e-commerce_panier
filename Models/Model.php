<?php

namespace App\Models;

use App\Core\Db;

// on fait abstract -> on ne peut pas la utiliser directement
abstract class Model extends Db
{
    // proprieté pout la table de la base de données
    protected $table;

    // proprieté pour l'instance
    private $db;

    

    // nous allons faire la methode qui va executer les requette
    /**
     * @param string $sql Requete sql à executer
     * @param array $attributs Attributs à ajouter à la requete
     * @return PDOStatement|false
     */
    public function requete(string $sql, array $attributs = null)   // si on ne met pas "null" , on met ? devant array
    {
        // on recupere l'instance de Db
        $this->db = Db::getInstance();

        // on verifie si on a les attrubuts

        if($attributs !== null){
            // Requete préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;

        }else{
            // Requete simple
            return $this->db->query($sql);

        }

    }

    public function findAll()
    {
        $query = $this->requete("SELECT * FROM $this->table");  // j'ai changé le syntacs de requete
        return $query->fetchAll();
    }

    

    public function findBy(array $criteres)   // toutes les informations
    {
        $champs = [];
        $valeurs = [];

        // on va boucler pour le tableau
        foreach($criteres as $champ => $valeur){
            // SELECT * FROM annonces WHERE actif = ?
            // bindvalue(1, valeur)

            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        // var_dump($champs);
        // var_dump($valeurs);
         // On transforme le tableau en chaîne de caractères séparée par des AND
        $liste_champs = implode(' AND ', $champs);

        // on execute requete
        return $this->requete("SELECT * FROM $this->table WHERE $liste_champs", $valeurs)->fetchAll();
        
    }

    public function find(int $id)   // on a une seul information
    {
        return $this->requete("SELECT * FROM $this->table WHERE id = $id")->fetch();

    }
    // Creation d
    //on peut passer n'import quel model
    public function create()
    {
        
        $champs = [];
        $inter = [];
        $valeurs = [];

        // on va boucler pour le tableau
        foreach($this as $champ => $valeur){
            // INSER INTO annonces (titer, description, actif) VALUES(?,?,?) 
            // condition pour ne pas inserertable et le nom de db
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ";
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
            
        }
        
         // On transforme le tableau en chaîne de caractères séparée par des AND
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        // echo $liste_champs; die($liste_inter);

        // Id de dernier article enregestré


        // on execute requete dans realité il faut priciser les champ avec des valeures
        return $this->requete("INSERT INTO $this->table ($liste_champs) VALUES($liste_inter)", $valeurs);
        //return $this->requete("INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_inter . ')", $valeurs);

    }

    // la methode hydratation 
    public function hydrate($donnees)
    {
        foreach($donnees as $key => $value){
            // on recuper le nom de setteur correspondant à la cle
            // titre -> setTitre
            $setter = 'set'.ucfirst($key);
            // on verifie si setteur existe
            if(method_exists($this, $setter)){
                // on appel le setteur si la methode  existe
                $this->$setter($value);
            }

        }
        return $this;
    }

    // Mis à jour

    public function update()
    {
        
        $champs = [];
        $valeurs = [];

        // on va boucler pour le tableau
        foreach($this as $champ => $valeur){
            // UPDATE annonces SET  titer=?, description=?, actif=? WHERE id=? 
            // condition pour ne pas inserertable et le nom de db
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
            
        }
        $valeurs[] = $this->id;
        
         // On transforme le tableau en chaîne de caractères séparée par des AND
        $liste_champs = implode(', ', $champs);

        // echo $liste_champs; die($liste_inter);

        // on execute requete
        return $this->requete("UPDATE $this->table SET $liste_champs WHERE id=?", $valeurs);
    }

    // DELETE Supprision

    public function delete(int $id)
    {
        return $this->requete("DELETE FROM $this->table WHERE id=?", [$id]);
    }


    



}