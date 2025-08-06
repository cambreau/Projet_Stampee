<?php 

// Affiche les erreurs utilent pour le développement. 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Session
session_start();

require_once 'vendor/autoload.php';
require_once './config.php';
require_once 'routes/web.php';

 ?>