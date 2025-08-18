<?php
namespace App\Controllers;
use App\Models\Couleurs;
use App\Models\Etat;
use App\Models\Enchere;
use App\Models\Pays;
use App\Models\Timbre;
use App\Providers\View;
use App\Models\Images;

class RequetesFrontController{

/* Communication data avec front-end timbre */
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


    public function recupererTousTimbres(){
       //** Récupérer les informations des timbres du membre.
       $timbreCrud = new Timbre;
       $timbres = $timbreCrud->select();
       $imagesCrud = new Images;
       $enchereCrud = new Enchere;

       foreach($timbres as &$timbre){
            // 1. Récupérer les images pour chaque timbre.
            $timbre['images']=$imagesCrud->selectWhere($timbre['id'],'timbreId');
            for ($i = 0; $i < count($timbre['images']); $i++) {
                if ($timbre['images'][$i]['principale'] == 1) {
                    $timbre['principale'] = $timbre['images'][$i];
                    unset($timbre['images'][$i]); // Retire l'image principale de la liste
                    break; // On arrête après la première trouvée
                }
            }
            // 2. Récupérer les informartions encheres pour chaque timbre.
            $timbre['encheres'] = $enchereCrud-> selectWhere($timbre['id'],'timbreId'); 
        } 
         
        // ** Transformer les informations en JSON.
        header('Content-Type: application/json'); // Indique au navigateur que la réponse renvoyée est du JSON, pas du HTML ou du texte brut.
        $jsonTimbres = json_encode($timbres); // Transforme en JSON.
        echo  $jsonTimbres; // Envoie au front-end les informations
    }    
}


