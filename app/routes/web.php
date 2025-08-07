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
Route::post('/connexion/page-connexion', 'ConnexionController@connexion');
Route::post('/connexion/deconnexion', 'ConnexionController@deconnexion');

//Membre
Route::get('/membre/page-inscription', 'MembreController@pageInscription');
Route::post('/membre/page-inscription', 'MembreController@inscription');
Route::get('/membre/profil', 'MembreController@pageProfil');
Route::get('/membre/page-modifier', 'MembreController@pageModifier');
Route::post('/membre/page-modifier', 'MembreController@modifier');
Route::get('/membre/supprimer', 'MembreController@supprimer');

Route::dispatch();


