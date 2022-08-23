<?php

namespace App;

class Autoloader
{
    static function register()   // les methode static sont accessible sans besoin instancier la class
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload($class)
    {
        //echo $class;   // dans $class nous avons totalité de namespace de la classe concernée(App\Client/Compte.php)
        //on retir App\
        $class = str_replace(__NAMESPACE__ . "\\", '', $class);
        //on remplace les \ par /
        $class = str_replace("\\", '/', $class);

        // on verifie si le fichier existe
        $fichier = __DIR__ . '/' . $class . '.php';
        if(file_exists($fichier)){
            require_once $fichier;
        }

        

    }

}