<?php
use App\Routes\Route;

//Accueil
Route::get('', 'AccueilController@index');
Route::get('/', 'AccueilController@index');
Route::get('/accueil', 'AccueilController@index');
Route::get('/index', 'AccueilController@index');
Route::get('/index.php', 'AccueilController@index');


//Connexion
Route::get('/connexion/page-connexion', 'ConnexionController@pageConnexion');

//Membre
Route::get('/membre/page-inscription', 'MembreController@pageInscription');


Route::dispatch();


