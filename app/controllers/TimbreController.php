<?php
namespace App\Controllers;
use App\Models\Couleurs;
use App\Models\Etat;
use App\Models\Pays;
use App\Providers\View;
use App\Providers\Validation;

class TimbreController{
    public function pageAjoutTimbre(){
       // Il faut être connecté pour accéder à la page d’ajout des timbres. On valide si $_SESSION['membre_id'] existe.
       if(!isset($_SESSION['membre_id'])){
        return View::render('erreur404', ['message'=>"Erreur - Vous devez être connecté pour ajouter un timbre!"]);
       }
       else{
        // On récupère les informations nécessaires pour le formulaire.
        //Couleurs:
        $couleursCrud = new Couleurs;
        $couleurs = $couleursCrud->select();
        //Etat:
        $etatCrud = new Etat;
        $etats = $etatCrud->select();
        //Pays:
        $paysCrud = new Pays;
        $pays = $paysCrud->select();

        // On renvoie à la page du formulaire.
        return View::render('/timbre/ajout-timbre',['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays]);
    }
    }
}