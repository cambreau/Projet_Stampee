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
            return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
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

    public function pageProfil(){
        if(isset($_SESSION['membre_id'])){
          //** Récupérer les informations du membre. 
          $membreCrud = new Membre();
          $membre = $membreCrud ->selectId($_SESSION['membre_id']);
          //** Si $membre existe alors on renvoie vers le profil du membre
          if($membre){
            $session = $_SESSION ?? null;
            return View::render('/membre/profil',['membre'=>$membre,'session'=>$session]);  
          }
          else{
            return View::render('erreur404',['message'=>"Erreur 404 - Une erreure s'est produite."]);  
          }
        }  
    }

    public function pageModifier (){
        if($_GET['id'] != $_SESSION['membre_id']){
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
          }
          else{
             //Récupérer les informations du membre.
            $membreCrud= new Membre();
            $membre= $membreCrud->selectId($_SESSION['membre_id']);
            //Renvoyer vers la view de modification des utilisateurs.
            return View::render('/membre/page-modifier',['membre'=>$membre]);
          }
    }

    public function modifier($data){
        // Si la méthode est différente de POST, on renvoie à la page 404.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
        }
        else{
            // Validation des $data.
            $Validation = new Validation;
            $Validation->field('nomUtilisateur',$data['nomUtilisateur'])->min(2)->max(45);
            $Validation->field('nom',$data['nom'])->min(2)->max(45);
            $Validation->field('prenom',$data['prenom'])->min(2)->max(45);
            $Validation->field('email',$data['email'])->min(2)->max(45)->email();
            $Validation->field('motDePasse',$data['motDePasse'])->formatMotDePasse();
            $Validation->field('confirmationMotPasse',$data['confirmationMotPasse'])->confirmationChampIdentique($data['motDePasse']);
            
            // Si la validation est correcte.
            if($Validation->estUnSucces()){
                //** On ajoute les données dans la table "membre".
                $membreCrud = new Membre;
                $data['motDePasse'] = $membreCrud ->hashMotDePasse($data['motDePasse']);
                $membreAjour = $membreCrud ->update($data,$_SESSION['membre_id']);
             
               
                // Si la modification du membre dans la base de données a fonctionné, on renvoie vers la page de profil avec un message de succès.
                if($membreAjour){
                    $membre= $membreCrud->selectId($_SESSION['membre_id']);
                    return View::render('/membre/profil',['membre'=>$membre]);
                // Si la modification a échoué, alors on renvoie vers la page 404, avec un message d'erreur.
                }else{
                    return View::render('erreur404', ['message'=>"404 - Les modifications ont échoué"]);  
                }
            // Si la validation n'est pas bonne.    
            }else{
                // On recupère les erreurs.    
                $erreurs = $Validation->geterreurs();
                // On renvoie à la page d'inscription, avec les erreurs.
                return View::render('/membre/page-modifier',['erreurs'=>$erreurs,'membre'=>$data]);
           }   
        }
    }

    public function supprimer(){
        if($_GET['id'] != $_SESSION['membre_id']){
          return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
        }
        else{
          // Validation que la requete soit arrive par GET
          if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!']);
          }
          else{
            // On recupere l'id et on supprime la ligne dans la table membre.
            $id=$_GET["id"];
            $crudMembre = new Membre;
            $membreSupprime = $crudMembre ->delete($id);
            // Si la suppression a fonctionne on renvoie a la page de connexion avec un message de succes, sinon on redirige vers la page d'erreur.
              if($membreSupprime){
                session_destroy();
                return View::redirect('connexion/page-connexion');
              }
              else{
                return View::render('erreur404', ['message'=>"404 - La suppresion a échoué"]);
              }
          }
        }
      }
}
