<?php
namespace App\Core;

// on import PDO , class existante

use PDO;
use PDOException;

class Db extends PDO
{
    // instance unique de la classe
    private static $instance;

    // Bdd "localhost"
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'shopsite';


    private function __construct()
    {
        //DSN de connexion
        $_dsn = 'mysql:dbname='. self::DBNAME . ';host=' . self::DBHOST;
        
        // on appele le constructeur de la class PDO
        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            // on change FETCH_ASSOC à FETCH_OBJ pour simplifier affichage dans Views quand on fait boucle
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // on verifie si il y a l'instance , si non ,on la instancie une fois

    public static function getInstance():self
    {
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;

    }
}
