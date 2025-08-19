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

//Timbre 
Route::get('/timbre/ajout-timbre', 'TimbreController@pageAjoutTimbre');
Route::post('/timbre/ajout-timbre','TimbreController@ajouterTimbre' );
Route::get('/timbre/page-modifier','TimbreController@pageModifierTimbre');
Route::post('/timbre/page-modifier','TimbreController@modifierTimbre');
Route::get('/timbre/supprimer','TimbreController@supprimerTimbre');


//Encheres
Route::get('/enchere/catalogue-encheres', 'EnchereController@pageCatalogueEncheres');
Route::get('/enchere/fiche-detail-enchere','EnchereController@pageFicheDetailEncheres');

//Requetes front vers back-end 
Route::get('/requete/timbreMembreID','RequetesFrontController@recupererTimbresMembreID' );
Route::get('/requete/tousTimbres','RequetesFrontController@recupererTousTimbres' );
Route::delete('/requete/supprimerImageBD','RequetesFrontController@supprimerImageBD' );

Route::dispatch();


