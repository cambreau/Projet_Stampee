<?php
namespace App\Controllers;
use App\Models\Couleurs;
use App\Models\Etat;
use App\Models\Enchere;
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
                $Validation->field('nom',$data['nom'])->min(2)->max(200)->unique('Timbre');
                $Validation->field('dateEmission',$data['dateEmission'])->obligatoire();
                $Validation->field('tirage',$data['tirage'])->min(1);
                $Validation->field('dimension',$data['dimension'])->min(2)->max(45);
                $Validation->field('couleursId',$data['couleursId'])->obligatoire();
                $Validation->field('paysId',$data['paysId'])->obligatoire();
                $Validation->field('etatId',$data['etatId'])->obligatoire();
                
                // Validation des images
                $imagesCrud = new Images;
                $validationImages = $imagesCrud->validationImage($_FILES['images']);
                
                // Si la validation des $data et la validation des images.
                if($Validation->estUnSucces() && $validationImages === true){
                        $timbreCrud = New Timbre;
                        $data['membreId']=$_SESSION['membre_id'];
                        $ajoutTimbre = $timbreCrud->insert($data);
                        // Si l'ajout du timbre à fonctionné, on ajoute les images.
                        if($ajoutTimbre){
                            $erreursImage=[];
                            // On prépare les images pour l'import.
                            $imagesImport = $imagesCrud->formatterImage($_FILES['images'],$ajoutTimbre);
                            for ($i = 0; $i < count($imagesImport); $i++) {
                                $image=['lien'=>$imagesImport[$i],'principale'=>0,'timbreId'=>$ajoutTimbre];
                                if($i === 0){
                                    $image=['lien'=>$imagesImport[$i],'principale'=>1,'timbreId'=>$ajoutTimbre];
                                }
                                $importationImage = $imagesCrud->insert($image);
                                // Si l'importation d'image ne fonctionne pas, on enregistre l'erreur dans la variable $erreursImage.
                                if(!$importationImage){
                                    array_push($erreursImage, $i);
                                }  
                            }   
                            // S'il n'y a pas d'erreur d'importation d'image, on recupère toutes les informations importées.
                            if(empty($erreursImage))
                            {
                                $timbre=$timbreCrud->selectId($ajoutTimbre);
                                $imageTimbre=$imagesCrud->selectWhere($ajoutTimbre,'timbreId');
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
                                var_dump($erreursImage);
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

    public function recupererTimbresMembreID(){
        // ** Il faut être connecté pour recuperer les informations sur les timbres. On valide si $_SESSION['membre_id'] existe.
        if(!isset($_SESSION['membre_id'])){
            return View::render('/connexion/page-connexion', ['message'=>'Veuillez vous connecter pour ajouter un timbre!']);
        }
        else{
            //** Récupérer les informations des timbres du membre.
           $timbreCrud = new Timbre;
           $timbres = $timbreCrud->selectWhere($_SESSION['membre_id'],'membreId');

           $etatCrud = new Etat;
           $paysCrud = new Pays;
           $couleursCrud = new Couleurs;
           $imagesCrud = new Images;
           $enchereCrud = new Enchere;

           foreach($timbres as &$timbre){
                // 1. Récupérer  le nom de l'etat pour l'affichage.
                $timbre['etat']= $etatCrud->selectWhere($timbre['etatId'], 'id');
                // 2. Récupérer  le nom du pays d'origine pour l'affichage.
                $timbre['pays']= $paysCrud->selectWhere($timbre['paysId'], 'id');
                // 3. Récupérer  le nom de la couleur pour l'affichage.
                $timbre['couleur']= $couleursCrud->selectWhere($timbre['couleursId'], 'id');
                // 4. Récupérer les images pour chaque timbre.
                $timbre['images']=$imagesCrud->selectWhere($timbre['id'],'timbreId');
                for ($i = 0; $i < count($timbre['images']); $i++) {
                    if ($timbre['images'][$i]['principale'] == 1) {
                        $timbre['principale'] = $timbre['images'][$i];
                        unset($timbre['images'][$i]); // Retire l'image principale de la liste
                        break; // On arrête après la première trouvée
                    }
                }
                // 5. Récupérer les informartions encheres pour chaque timbre.
                $timbre['encheres'] = $enchereCrud-> selectWhere($timbre['id'],'timbreId'); 
            } 
             
            // ** Transformer les informations en JSON.
               header('Content-Type: application/json'); // Indique au navigateur que la réponse renvoyée est du JSON, pas du HTML ou du texte brut.
               $jsonTimbres = json_encode($timbres); // Transforme en JSON.
               echo $jsonTimbres; // Envoie au front-end les informations
        }    
    }


}