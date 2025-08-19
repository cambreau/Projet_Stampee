<?php
namespace App\Models;
use App\Models\CRUD;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class Images extends CRUD {
    protected $table = "image";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'lien','principale','timbreId'];

    public function validationImage($image){
        //Déclaration des extensions acceptées pour l'enregistrement.
        $extensionsAcceptees=['gif','jpg','jpeg', 'png','webp'];
        //Déclaration du tableau qui contiendra le numéro des images en erreur.
        $erreursImage=[];

        //Logique 
        // Validation taille:
        if ($image['error'] !== UPLOAD_ERR_OK) {
            // Gestion des erreurs selon le code
            switch ($image['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $message = "Le fichier " . $image['name'] . " est trop volumineux.";
                    array_push($erreursImage, $message);
            }
        }
        else{
            //Validation de l'extension:
            //Recuperer l'extension Ref: https://www.php.net/manual/en/function.image-type-to-extension.php
            //Ref: https://www.php.net/manual/fr/function.strtolower
            $extension = pathinfo( strtolower($image['name']), PATHINFO_EXTENSION );
            //Comparer avec les extensions acceptées Ref: https://www.php.net/manual/fr/function.in-array.php
            if(!in_array($extension, $extensionsAcceptees)){
                $message = "Le type d'extension de l'image " . $image['name'] . " n'est pas supportées par le système.";
                array_push($erreursImage, $message);
            }
        }
        //Retour
        if(empty($erreursImage)){
            return true;
        }
        else{
            return $erreursImage;
        }
    }

    public function formatterImage($imageInput, $id){
        // Driver = le moteur qui fait le travail réel sur les images, ic gd.
        $manager = new ImageManager(new Driver());
        // Crée l'image avec Intervention\Image\ImageManager;
        $image = $manager->read($imageInput['tmp_name']);
        // Mise en forme.
        $image->resize(800, 800)->pad(800, 800, '#f7f7f7', position: 'center');
        // Generer un nom unique. Ref = https://www.php.net/manual/fr/function.uniqid
        $nomWebp = "img__" . $id . "__" . uniqid() . ".webp";
        // Enregistrer en WebP
        $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
        // On enregistre localement l'image.
        $cheminImage = 'C:\Users\breau\Documents\AEC\Projet1\Camille-Breau-Projet1\public\assets\images\images-timbre\\' . $nomWebp ;
        $image->save($cheminImage);  
        return $nomWebp;
    }

    public function suppressionImage($image){
        $cheminImage = 'C:\Users\breau\Documents\AEC\Projet1\Camille-Breau-Projet1\public\assets\images\images-timbre\\' . $image["lien"];
        unlink($cheminImage);
    }
}
