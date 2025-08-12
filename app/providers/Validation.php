<?php
namespace App\Providers;

class Validation {
    private $erreurs = array();
    private $cle;
    private $valeur;
    private $nom;


    /**
     * La méthode field() enregistre un champ (clé, valeur) en mettant la première lettre du nom en majuscule.
     * Met la première lettre d'une chaîne de caractères en majuscule, et laisse le reste inchangé.
     * https://www.php.net/manual/en/function.ucfirst.php 
     */
    public function field($cle, $valeur, $nom = null){
        $this->cle = $cle;
        $this->valeur = $valeur;
        if($nom == null){
            $this->nom = ucfirst($cle);
        }else{
            $this->nom = ucfirst($nom);
        }
        return $this;
    }

    /**
     * Valide que la valeur ne soit pas nulle, sinon renvoie un message d’erreur.
     */
    public function obligatoire(){
        if(empty($this->valeur)){
            $this->erreurs[$this->cle] = "$this->nom est obligatoire";
        }
        return $this;
    }

    /**
     * Valide que la valeur ait une longueur inférieure ou égale à la taille maximum autorisée.
     * https://www.php.net/manual/fr/function.strlen.php Calcul la taille d'une chaîne de caractères.
     */
    public function max($length){
        if(strlen($this->valeur) > $length ){
            $this->erreurs[$this->cle] = "$this->nom doit avoir moins de $length caractères";
        }
        return $this;
    }

    /**
     * Valide que la valeur ait une longueur supérieure à la taille minimum autorisée.
     */
    public function min($length){
        if(strlen($this->valeur) < $length ){
            $this->erreurs[$this->cle] = "$this->nom doit avoir plus de $length caractères";
        }
        return $this;
    }

    /**
     * Valide le format de l'adresse courriel
     * https://www.php.net/manual/en/function.filter-var.php
     */
    public function email() {
        if (!empty($this->valeur) && !filter_var($this->valeur, FILTER_VALIDATE_EMAIL)) {
            $this->erreurs[$this->cle]="Format $this->nom invalid.";
        }
        return $this;
    }

    /**
    * Vérifie que la valeur du champ est unique..
     */
    public function unique($model){
        $model = 'App\\Models\\'.$model;
        $model = new $model;
        $unique = $model->unique($this->cle, $this->valeur);
        if($unique){
            $this->erreurs[$this->cle]="$this->nom doit être unique.";
        }
        return $this;
    }

    /* Valide le format des mot de passes */
    public function formatMotDePasse(){
        $regEx = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
        $valide = preg_match($regEx,$this->valeur);
        if(!$valide){
            $this->erreurs[$this->cle]=" Le mot de passe est obligatoire et doit contenir au minimum 8
              caractères dont une lettre et un chiffre.";
        }
        return $this;
    }

    /* Si deux champs ne sont pas identiques retourne une message d'erreur */
    public function confirmationChampIdentique($dataOriginale){
        if($this->valeur !== $dataOriginale){
            $this->erreurs[$this->cle]="Les deux champs doivent être identiques";  
        }
    }


    public function estDejaUtilise($model, $id){
        //On recupere la liste des enregistrement qui ont la meme valeur
        $model = 'App\\Models\\'.$model;
        $model = new $model;
        $resultats = $model->selectWhere($this->valeur,$this->cle);
        //On valide si la valeur existe pour un autre id.
        foreach ($resultats as $resultat) {
            if ($resultat['id'] != $id) {
                if ($resultat[$this->cle] === $this->valeur) {
                    $this->erreurs[$this->cle]="La valeur '{$this->valeur}' est déjà utilisée.";
                }
            }
        }
    }

    /**
     * Si il n'y a aucune erreur retourne vrai.
     */
    public function estUnSucces(){
        if(empty($this->erreurs)) return true;
    }

    /**
     * Si estUnSucces() = false alors renvoie la variable erreurs.
     */
    public function geterreurs(){
        if(!$this->estUnSucces()) return $this->erreurs;
    }
}
?>