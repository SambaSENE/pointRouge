<?php 

namespace App\Controllers;

class HomeController{
    
    public function index() : void
    {
        echo 'Bienvenue sur la page d\'acceuil';
    }
    /**
     * Affiche la page "À propos".
     *
     * @return void
     */
    public function about(): void
    {
        echo 'À propos de nous';
    }
}