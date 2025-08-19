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
        // Il faut être connecté pour ajouter des timbres. On valide si $_SESSION['membre_id'] existe.
        if(!isset($_SESSION['membre_id'])){
            return View::render('/connexion/page-connexion', ['message'=>'Veuillez vous connecter pour ajouter un timbre!']);
        }
        else{
            $session = $_SESSION ?? null;
            // Il faut que la requête soit de type POST, sinon on renvoie à la page d’erreur.
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!','session'=>$session]);
            }
            else{
                // Validation des $data.
                $Validation = new Validation;
                $Validation->field('nom',$data['nom'])->min(2)->max(60)->unique('Timbre');
                $Validation->field('dateEmission',$data['dateEmission'])->obligatoire();
                $Validation->field('tirage',$data['tirage'])->min(1);
                $Validation->field('dimension',$data['dimension'])->min(2)->max(45);
                $Validation->field('couleursId',$data['couleursId'])->obligatoire();
                $Validation->field('paysId',$data['paysId'])->obligatoire();
                $Validation->field('etatId',$data['etatId'])->obligatoire();
                
                // Validation des images
                $imagesCrud = new Images;
                $validationImagePrincipale = $_FILES['principale']['error'] !== UPLOAD_ERR_NO_FILE ? $imagesCrud->validationImage($_FILES['principale']) : ["L'image principale est obligatoire"];
                // Initialisation d'un variable erreur Image
                $erreursImage=[];
                if($_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE){
                    foreach($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $image = [
                            'name' => $_FILES['images']['name'][$key],
                            'tmp_name' => $tmpName,
                            'error' => $_FILES['images']['error'][$key]
                        ];
                        $validationImage = $imagesCrud->validationImage($image); 
                        if($validationImage !== true){
                            array_push($erreursImage, $validationImage); 
                        }
                    }
                }
                // Si la validation des $data et la validation des images.
                if($Validation->estUnSucces() && empty($erreursImage) && $validationImagePrincipale === true){
                    $timbreCrud = New Timbre;
                    $data['membreId']=$_SESSION['membre_id'];
                    $ajoutTimbre = $timbreCrud->insert($data);
                    // Si l'ajout du timbre à fonctionné, on ajoute les images.
                    if($ajoutTimbre){
                        // On prépare les images pour l'import.
                        $imagePrincipaleImport = $imagesCrud->formatterImage($_FILES['principale'],$ajoutTimbre);
                        $imagePrincipale = ['lien'=>$imagePrincipaleImport,'principale'=>1,'timbreId'=>$ajoutTimbre];
                        $importationImagePrincipale = $imagesCrud->insert($imagePrincipale);
                        if($_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE){
                                foreach($_FILES['images']['tmp_name'] as $key => $tmpName) {
                                    $image = [
                                        'name' => $_FILES['images']['name'][$key],
                                        'tmp_name' => $tmpName,
                                        'error' => $_FILES['images']['error'][$key]
                                    ];
                                    $imageFormatter = $imagesCrud->formatterImage($image,$ajoutTimbre);
                                    $imageImport=['lien'=>$imageFormatter,'principale'=>0,'timbreId'=>$ajoutTimbre];
                                    $importationImage = $imagesCrud->insert($imageImport); 
                                }
                        }
                        //On recupere les infos.
                        $timbre=$timbreCrud->selectId($ajoutTimbre);
                        //Couleur:
                        $couleursCrud = new Couleurs;
                        $timbre['couleur']= $couleursCrud->selectId($timbre['couleursId']);
                        //Etat:
                        $etatCrud = new Etat;
                        $timbre['etat']= $etatCrud->selectId($timbre['etatId']);
                        //Pays:
                        $paysCrud = new Pays;
                        $timbre['pays']= $paysCrud->selectId($timbre['paysId']);
                        //Images:
                        $imageTimbre=$imagesCrud->selectWhere($ajoutTimbre,'timbreId');
                            for ($i = 0; $i < count($imageTimbre); $i++) {
                                if ($imageTimbre[$i]['principale'] == 1) {
                                    unset($imageTimbre[$i]); // Retire l'image principale de la liste
                                    break; // On arrête après la première trouvée
                                }
                            }
                        return View::render('enchere/fiche-detail-enchere',['timbre'=>$timbre,'imageTimbre'=>$imageTimbre,'imagePrincipale'=>$imagePrincipale,'session'=>$session]); 
                    }
                    else{
                        return View::render('erreur404', ['message'=>"Erreur 404 - Erreur lors de l'ajout du timbre!",'session'=>$session]);   
                    }
                }   
                else{
                    $erreurs = $Validation->geterreurs();
                    $erreursImagePrincipale=$validationImagePrincipale;

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
                    return View::render('/timbre/ajout-timbre',['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays,'timbre'=>$data, 'images'=>$_FILES['images'], 'imagePrincipale'=>$_FILES['principale'],'erreurs'=>$erreurs,'erreursImage'=>$erreursImage, 'erreursImagePrincipale'=>$erreursImagePrincipale,'session'=>$session]);
                } 
            } 
        }
    }    

    public function pageModifierTimbre(){
        // Valider que l'utilisateur est bien le proprietaire du timbre.
        $timbreCrud = new Timbre;
        $timbre = $timbreCrud->selectId($_GET['id']);
        if($_SESSION['membre_id'] != $timbre['membreId']){
            return View::render('erreur404', ['message'=>"Erreur - Vous n'avez pas les droits!"]);
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
            //Images:
            $imageCrud= new Images;
            $images = $imageCrud->selectWhere($_GET['id'],'timbreId');
            $imagePrincipale = null; // Initialisation de la varialbe pour retourner a la view.
            for ($i = 0; $i < count($images); $i++) {
                if ($images[$i]['principale'] == 1) {
                    $imagePrincipale = $images[$i];
                    unset($images[$i]); // Retire l'image principale de la liste
                    break; // On arrête après la première trouvée
                    }
                }
            $session = $_SESSION ?? null;
            return View::render('/timbre/page-modifier-timbre', ['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays,'timbre'=>$timbre,'images'=>$images, 'imagePrincipale'=>$imagePrincipale, 'session'=>$session]);
        }
    }

    public function modifierTimbre($data){
        // Il faut être connecté pour modifier les timbres. On valide si $_SESSION['membre_id'] existe.
        if(!isset($_SESSION['membre_id'])){
            return View::render('/connexion/page-connexion', ['message'=>'Veuillez vous connecter pour modifier un timbre!']);
        }
        else{
            $session = $_SESSION ?? null;
            // Il faut que la requête soit de type POST, sinon on renvoie à la page d’erreur.
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return View::render('erreur404', ['message'=>'Erreur 404 - Page introuvable!','session'=>$session]);
            }
            else{
                // VALIDATION
                // ** Validation timbre
                $Validation = new Validation;
                $Validation->field('dateEmission',$data['dateEmission'])->obligatoire();
                $Validation->field('tirage',$data['tirage'])->min(1);
                $Validation->field('dimension',$data['dimension'])->min(2)->max(45);
                $Validation->field('couleursId',$data['couleursId'])->obligatoire();
                $Validation->field('paysId',$data['paysId'])->obligatoire();
                $Validation->field('etatId',$data['etatId'])->obligatoire();
                 // ** Validation image principale
                 $imageCrud = new Images;
                 $validationImagePrincipale = $_FILES['principale']['error'] !== UPLOAD_ERR_NO_FILE ?$imageCrud->validationImage($_FILES['principale']) : true;
                // ** Validation autres images
                // Initialisation d'un variable erreur Image
                $erreursImage=[];
                if($_FILES['images']['error'] !== UPLOAD_ERR_NO_FILE){
                    foreach($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $image = [
                            'name' => $_FILES['images']['name'][$key],
                            'tmp_name' => $tmpName,
                            'error' => $_FILES['images']['error'][$key]
                        ];
                        $validationImage = $imageCrud->validationImage($image); 
                        if($validationImage !== true){
                            array_push($erreursImage, $validationImage); 
                        }
                    }
                }

                // IMPORT
                if($Validation->estUnSucces() && empty($erreursImage) && $validationImagePrincipale === true){
                    // ** Import timbre
                    $timbreCrud = New Timbre;
                    $data['membreId']=$_SESSION['membre_id'];
                    $modifTimbre = $timbreCrud->update($data, $data['id'] );
                    // Si l'ajout du timbre à fonctionné, on ajoute les images.
                    if($modifTimbre){
                        // ** Import image principale.
                        //Si l'utilisateur a choisi une nouvelle image principale:
                        if($_FILES['principale']['error'] !== UPLOAD_ERR_NO_FILE) {
                            $images = $imageCrud->selectWhere( $data['id'],'timbreId');
                            // 1- On supprime l'image existante.
                            for ($i = 0; $i < count($images); $i++) {
                                if ($images[$i]['principale'] == 1) {
                                    $SupprimerancienneImagePrincipale = $imageCrud->delete($images[$i]['id']);
                                    $imageCrud->suppressionImage($images[$i]);
                                    unset($images); // Retire les autres images.
                                    break; // On arrête après la première trouvée
                                }
                            }
                            // 2- On importe la nouvelle image.
                            $imagePrincipaleImport = $imageCrud->formatterImage($_FILES['principale'],$modifTimbre);
                            $imagePrincipale = ['lien'=>$imagePrincipaleImport,'principale'=>1,'timbreId'=>$data['id']];
                            $importationImagePrincipale = $imageCrud->insert($imagePrincipale);
                        }
                        // ** Import des autres images. 
                        if($_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE ){
                            foreach($_FILES['images']['tmp_name'] as $key => $tmpName) {
                                $image = [
                                    'name' => $_FILES['images']['name'][$key],
                                    'tmp_name' => $tmpName,
                                    'error' => $_FILES['images']['error'][$key]
                                ];
                                $imageFormatter = $imageCrud->formatterImage($image,$data['id']);
                                $imageImport=['lien'=>$imageFormatter,'principale'=>0,'timbreId'=>$data['id']];
                                $importationImage = $imageCrud->insert($imageImport); 
                            }
                        }   
                            //On recupere les infos.
                            $timbre=$timbreCrud->selectId($data['id']);
                            //Couleur:
                            $couleursCrud = new Couleurs;
                            $timbre['couleur']= $couleursCrud->selectId($timbre['couleursId']);
                            //Etat:
                            $etatCrud = new Etat;
                            $timbre['etat']= $etatCrud->selectId($timbre['etatId']);
                            //Pays:
                            $paysCrud = new Pays;
                            $timbre['pays']= $paysCrud->selectId($timbre['paysId']);
                            //Image principale:
                            $imagePrincipale; //Initialisation de l`image principale pour le renvoie.
                            $imageTimbre=$imageCrud->selectWhere($data['id'],'timbreId');
                            for ($i = 0; $i < count($imageTimbre); $i++) {
                                    if ($imageTimbre[$i]['principale'] == 1) {
                                        $imagePrincipale = $imageTimbre[$i];
                                        unset($imageTimbre[$i]); // Retire l'image principale de la liste
                                        break; // On arrête après la première trouvée
                                    }
                            }
                            return View::render('timbre/fiche-detail-timbre',['timbre'=>$timbre,'imageTimbre'=>$imageTimbre,'imagePrincipale'=>$imagePrincipale,'session'=>$session]);        
                        }
                        else{
                            return View::render('erreur404', ['message'=>'Erreur 404 - Erreur lors de la modification!','session'=>$session]);   
                        }
                }
                else{
                    $erreurs = $Validation->geterreurs();
                    $erreursImagePrincipale=$validationImagePrincipale;

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
                    return View::render('/timbre/page-modifier-timbre',['couleurs'=>$couleurs, 'etats'=>$etats,'pays'=>$pays,'timbre'=>$data, 'images'=>$_FILES['images'], 'imagePrincipale'=>$_FILES['principale'],'erreurs'=>$erreurs,'erreursImage'=>$erreursImage, 'erreursImagePrincipale'=>$erreursImagePrincipale,'session'=>$session]);
                } 
            }
        } 
    }    
    
}    