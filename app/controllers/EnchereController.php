<?php
namespace App\Controllers;
use App\Providers\View;
use App\Models\Couleurs;
use App\Models\Etat;
use App\Models\Pays;
use App\Models\Timbre;
use App\Models\Enchere;
use App\Models\Images;


class EnchereController{
    public function pageCatalogueEncheres(){
        $session = $_SESSION ?? null;
        return View::render('/enchere/catalogue-encheres',['session'=>$session]);
    }

    public function pageFicheDetailEncheres(){
        $session = $_SESSION ?? null;
         //On recupere les infos du timbre.
         $timbreCrud = new Timbre;
         $timbre=$timbreCrud->selectId($_GET['id']);
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
        $imagesCrud = new Images;
        $imagePrincipale = null;
          $imageTimbre=$imagesCrud->selectWhere($_GET['id'],'timbreId');
          for ($i = 0; $i < count($imageTimbre); $i++) {
              if ($imageTimbre[$i]['principale'] == 1) {
                  $imagePrincipale = $imageTimbre[$i];
                  unset($imageTimbre[$i]); // Retire l'image principale de la liste
                  break; // On arrête après la première trouvée
              }
          }

        //Encheres:
        $encheresCrud = new Enchere;
        $enchere = $encheresCrud->selectWhere($_GET['id'],'timbreId');
        $enchere = $enchere[0];
         return View::render('/enchere/fiche-detail-enchere',['session'=>$session, 'timbre'=>$timbre, 'imageTimbre'=>$imageTimbre,'imagePrincipale'=>$imagePrincipale, 'enchere'=>$enchere]);
    }
}