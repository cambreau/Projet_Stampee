<?php
namespace App\Controllers;
use App\Providers\View;

class EnchereController{
    public function pageCatalogueEncheres(){
        $session = $_SESSION ?? null;
        return View::render('/enchere/catalogue-encheres',['session'=>$session]);
    }
}