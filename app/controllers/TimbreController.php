<?php
namespace App\Controllers;
use App\Models\Couleurs;
use App\Models\Etat;
use App\Models\Pays;
use App\Models\Timbre;
use App\Providers\View;
use App\Providers\Validation;
use App\Models\Images;

use Intervention\Image\ImageManager;

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
        $session = $_SESSION ?? null;
        // On renvoie à la page du formulaire.
        return View::render('/timbre/ajout-timbre',['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays,'session'=>$session]);
    }
    }

    public function ajouterTimbre($data){
        if(!isset($_SESSION['membre_id'])){
            
            return View::render('/connexion/page-connexion', ['message'=>'Veuillez vous connecter pour ajouter un timbre!']);
        }
        else{
            $session = $_SESSION ?? null;
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!','session'=>$session]);
            }
            else{
                // Validation des $data.
                $Validation = new Validation;
                $Validation->field('nom',$data['nom'])->min(2)->max(200);
                $Validation->field('dateEmission',$data['dateEmission'])->obligatoire();
                $Validation->field('tirage',$data['tirage'])->min(1);
                $Validation->field('dimension',$data['dimension'])->min(2)->max(45);
                $Validation->field('couleursId',$data['couleursId'])->obligatoire();
                $Validation->field('paysId',$data['paysId'])->obligatoire();
                $Validation->field('etatId',$data['etatId'])->obligatoire();
                
                // Validation des images
                $imagesCrud = new Images;
                $validationImages = $imagesCrud->validationImage($_FILES['images']);
                
                if($Validation->estUnSucces() && $validationImages === true){
                        $timbreCrud = New Timbre;
                        $data['membreId']=$_SESSION['membre_id'];
                        $ajoutTimbre = $timbreCrud->insert($data);
                        if($ajoutTimbre){
                            $erreursImage=[];
                            $imagesImport = $imagesCrud->formatterImage($_FILES['images'],$ajoutTimbre);
                            for ($i = 0; $i < count($imagesImport); $i++) {
                                $image=['lien'=>$imagesImport[$i],'principale'=>0,'timbreId'=>$ajoutTimbre];
                                if($i === 0){
                                    $image=['lien'=>$imagesImport[$i],'principale'=>1,'timbreId'=>$ajoutTimbre];
                                }
                                $importationImage = $imagesCrud->insert($image);
                                if(!$importationImage){
                                    array_push($erreursImage, $i);
                                }  
                                else{
                                    $timbre=$timbreCrud->selectId($ajoutTimbre);
                                    $imageTimbre=$imagesCrud->selectId($ajoutTimbre);
                                    foreach ($imageTimbre as $image) {
                                        if ($image['principale'] == 1) {
                                            $imagePrincipale = $image;
                                            unset($imageTimbre[$image]); // Retire l'image principale de la liste
                                            break; // On arrête après la première trouvée
                                        }
                                    }
                                    return View::render('timbre/fiche-detail-timbre',['timbre'=>$timbre,'imageTimbre'=>$imageTimbre,'imagePrincipale'=>$imagePrincipale,'session'=>$session]);
                                }
                            }
                        }    
                }
                else{
                    $erreurs = $Validation->geterreurs();
                    $erreursImage = $validationImages;
                       
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
                    return View::render('/timbre/ajout-timbre',['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays,'timbre'=>$data, 'images'=>$_FILES['images'],'erreurs'=>$erreurs,'erreursImage'=>$erreursImage,'session'=>$session]);
                } 
            } 

        }
    }
}