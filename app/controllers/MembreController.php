<?php
namespace App\Controllers;
use App\Providers\View;

class MembreController{
    public function pageInscription(){
        return View::render('/membre/page-inscription');
    }
};