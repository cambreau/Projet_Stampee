<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {
    static public function render($template, $data = []){
        /*FilesystemLoader est une classe fournie par Twig.
        Elle dit à Twig où trouver les fichiers .php à afficher.*/
        /*Cette ligne dit à Twig : "Quand je te demande d’afficher une page, regarde dans le dossier views/ pour la trouver."*/
        $loader = new FilesystemLoader('views');
        /* Environment est la classe principale de Twig.
        Elle représente le moteur de rendu : c’est lui qui va prendre un fichier HTML + des variables, et produire la page finale. */
        $twig = new Environment($loader);
        /* "Je donne à Twig deux variables (asset et base) qui seront disponibles dans toutes les pages, sans avoir besoin de les passer à chaque fois." */
        $twig->addGlobal('asset', ASSET);
        $twig->addGlobal('base', BASE);
        /* fonction qui génère le HTML final. */
        echo $twig->render($template.".php", $data);
    }

    static public function redirect($url){
        header('location:'.BASE.'/'.$url);
    }
}

?>