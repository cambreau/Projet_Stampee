<?php
namespace App\Controllers;
use App\Providers\View;

class ConnexionController{
    
    public function pageConnexion(){
        return View::render('/connexion/page-connexion');
    }
};