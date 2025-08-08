<?php
namespace App\Controllers;
use App\Providers\View;
use App\Providers\Validation;
use App\Models\Membre;

class ConnexionController{
    
    public function pageConnexion(){
        return View::render('/connexion/page-connexion');
    }

    public function connexion ($data){
        // Validation du format du nom utilisateur et du mot de passe.
         $Validation = new Validation;
         $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(50);
         $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
        // Si la validation est un succès. 
         if($Validation->estUnSucces()){
           // On valide que le mot de passe soit le bon.
            $membreCrud = new Membre;
            $checkUtilisateur = $membreCrud->checkUtilisateur($data['nomUtilisateur'], $data['motDePasse']);
            // Si le mot de passe est bon.
            if($checkUtilisateur){
               // On récupère les informations de l’utilisateur pour créer la session.
               $membre = $membreCrud->selectWhere($data['nomUtilisateur'],'nomUtilisateur');
               $membreSession = $membreCrud ->creationSession($membre[0]);
               $session = $_SESSION ?? null;
               return View::render('accueil', ['session'=>$session]);
            // Si le mot de passe n'est pas correct, on recupère les erreurs et on renvoie une message d'erreur.    
            }else{
                $erreurs = $Validation->geterreurs();
                $message = "Veuillez vérifier vos identifiants ";
                return View::render('/connexion/page-connexion', ['erreurs'=>$erreurs, 'message'=>$message]);
            }
           // Si la validation des champs n'est pas correcte, on recupère les erreurs et on les renvoie.   
         }else{
            $erreurs = $Validation->geterreurs();
            return View::render('/connexion/page-connexion', ['erreurs'=>$erreurs]);
         }
      }

    public function deconnexion (){
        // On détruit la session et on renvoie à la page de connexion.
        session_destroy();
        // On relance une nouvelle session vide
        session_start(); 
        return View::redirect('connexion/page-connexion');
    }
};