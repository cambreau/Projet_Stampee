<?php
namespace App\Controllers;
use App\Models\Membre;
use App\Providers\View;
use App\Providers\Validation;

class MembreController{
    public function pageInscription(){
        return View::render('/membre/page-inscription');
    }

    public function inscription($data){
        // Si la méthode est différente de POST, on renvoie à la page 404.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return View::render('erreur404', ['Erreur 404 - Page introuvable!']);
        }
        else{
            // Validation des $data.
            $Validation = new Validation;
            $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(45)->unique('Membre');
            $Validation->field('nom',$data['nom'])->min(2)->max(45);
            $Validation->field('prenom',$data['prenom'])->min(2)->max(45);
            $Validation->field('email',$data['email'])->min(2)->max(45)->email()->unique('Membre');
            $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
            $Validation->field('confirmationMotPasse',$data['confirmationMotPasse'])->confirmationChampIdentique($data['motDePasse']);
            
            // Si la validation est correcte.
            if($Validation->estUnSucces()){
                //** On ajoute les données dans la table "membre".
                $membreCrud = new Membre;
                $data['motDePasse'] = $membreCrud ->hashMotDePasse($data['motDePasse']);
                $membre = $membreCrud ->insert($data);
             
               
                // Si l'insertion du membre dans la base de données a fonctionné, on renvoie vers la page de connexion avec un message de succès.
                if($membre){
                    return View::render('/connexion/page-connexion',['msgCreation'=>"Profil créé avec succès!"]);
                // Si l'insertion a échoué, alors on renvoie vers la page 404, avec un message d'erreur.
                }else{
                    return View::render('erreur404', ['message'=>"404 - L'insertion a échoué"]);  
                }
            // Si la validation n'est pas bonne.    
            }else{
                // On recupère les erreurs.    
                $erreurs = $Validation->geterreurs();
                // On renvoie à la page d'inscription, avec les erreurs.
                return View::render('/membre/page-inscription',['erreurs'=>$erreurs,'membre'=>$data]);
           }   
        }
    }

    
};