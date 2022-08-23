<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $fichier, array $donnees = [], string $template = 'home')
    {
        // on extrer le contenu de $donnees
        extract($donnees);
        // on demarre le buffer de sortie
        ob_start();
        // à partir de la, toute sortie est conservé en memoire
        
        // on crée le chemin vers la Vue
        require_once ROOT. '/Views/'.$fichier.'.php';
        
        // on transffere le buffer vers contenue
        $contenu = ob_get_clean();
        // templaite de la page
        require_once ROOT. '/Views/'.$template.'.php';
    }
    
}