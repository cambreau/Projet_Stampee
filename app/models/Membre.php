<?php
namespace App\Models;
use App\Models\CRUD;

class Membre extends CRUD {
    protected $table = "membre";
    protected $clePrimaire = "id";
    protected $colonnes = ['id','nomUtilisateur', 'nom', 'prenom','email','motDePasse'];

    /**  Fonction qui hash un mot de passe
     * @param string mot de passe
     * @param int cost (ou coût) détermine combien d’itérations l’algorithme BCRYPT va effectuer pour générer le hash.
     * https://www.php.net/manual/fr/function.password-hash.php
    */
    public function hashMotDePasse($password, $cost = 10){
        $options = [
                'cost' => $cost 
        ]; // Permet de choisir un autre cost en parametre.
        return password_hash($password, PASSWORD_BCRYPT, $options); 
    }

    /**
     * Fonction qui valide si le nom utilisateur du membre est unique et valide si le mot de passe est bon.
     * @param string $nomUtilisateur
     * @param string $motDePasse
     * @return bool
     */
    public function checkUtilisateur($nomUtilisateur, $motDePasse){
        $utilisateur = $this->unique('nomUtilisateur',$nomUtilisateur);
        if($utilisateur){
            if(password_verify($motDePasse, $utilisateur['motDePasse'])){
                return true;
            }else{
                return false;   
            }
        }else{
            return false; 
        }
    }

    /** Fonction qui créer une session
     * @param array $membre
     */
    public function creationSession($membre){
        session_regenerate_id();
        $_SESSION['membre_id'] = $membre['id'];
        $_SESSION['membre_nomUtilisateur'] = $membre['nomUtilisateur'];
        $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
        return $_SESSION;
    }
};

