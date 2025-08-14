<?php
namespace App\Models;
use App\Models\CRUD;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class Images extends CRUD {
    protected $table = "image";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'lien','principale','timbreId'];

    public function validationImage($images){
        //Déclaration des extensions acceptées pour l'enregistrement.
        $extensionsAcceptees=['gif','jpg','jpeg', 'png','webp'];
        //Déclaration du tableau qui contiendra le numéro des images en erreur.
        $erreursImage=[];

        //Logique 
        $nbImages = count($images['name']);
        for ($i = 0; $i < $nbImages; $i++) {
            // Validation taille:
            if ($images['error'][$i] !== UPLOAD_ERR_OK) {
                // Gestion des erreurs selon le code
                switch ($images['error'][$i]) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $message = "Le fichier " . $images['name'][$i] . " est trop volumineux.";
                        array_push($erreursImage, $message);
                    case UPLOAD_ERR_NO_FILE:
                        $message = "Aucun fichier sélectionné pour l'upload.";
                        array_push($erreursImage, $message);
                }
            }
            else{
                //Validation de l'extension:
                //Recuperer l'extension Ref: https://www.php.net/manual/en/function.image-type-to-extension.php
                //Ref: https://www.php.net/manual/fr/function.strtolower
                $extension = pathinfo( strtolower($images['name'][$i]), PATHINFO_EXTENSION );
                //Comparer avec les extensions acceptées Ref: https://www.php.net/manual/fr/function.in-array.php
                if(!in_array($extension, $extensionsAcceptees)){
                    $message = "Le type d'extension de l'image " . $i . " n'est pas supportées par le système.";
                    array_push($erreursImage, $message);
                }
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
    public function formatterImage($images, $id){
        // Driver = le moteur qui fait le travail réel sur les images, ic gd.
        $manager = new ImageManager(new Driver());
        // Déclaration de la variable qui contiendra les images finales.
        $imagesWebp = [];
        for ($i = 0; $i < count($images['name']); $i++) {
            // Crée l'image avec Intervention\Image\ImageManager;
            $image = $manager->read($images['tmp_name'][$i]);

            // Mise en forme.
            $image->coverDown(800, 800);
            $image->pad(800, 800, '#f7f7f7', position: 'center');


            // Generer un nom unique. Ref = https://www.php.net/manual/fr/function.uniqid
            $nomWebp = "img__" . $id . "__" . uniqid() . ".webp";
            // Enregistrer en WebP
            $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
            array_push($imagesWebp, $nomWebp);
            }
             
        return $imagesWebp;
    }
}

