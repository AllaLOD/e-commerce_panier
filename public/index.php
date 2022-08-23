<?php
use App\Autoloader;
use App\Core\Main;

// on definie une constante le dossier racine du projet car c'est index.php qui est appelé
// la routeur vers racine
define('ROOT', dirname(__DIR__));
// en promoer à l'ouverture de l'application


//echo ROOT; 

// on apporte  l'autoloader
require_once ROOT.'/Autoloader.php';


Autoloader::register();

// on instancier Main (notre routeur)
$app = new Main();
// on demarre l'application 
$app->start(); // start c'est une function de la class Main






