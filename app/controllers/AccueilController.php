<?php
namespace App\Controllers;
use App\Providers\View;

class AccueilController{

    public function index(){
        $session = $_SESSION ?? null;
        return View::render('accueil',['session'=>$session]);
    }
}