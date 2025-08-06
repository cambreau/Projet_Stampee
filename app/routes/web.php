<?php
use App\Routes\Route;

Route::get('', 'AccueilController@index');
Route::get('/', 'AccueilController@index');
Route::get('/accueil', 'AccueilController@index');
Route::get('/index', 'AccueilController@index');
Route::get('/index.php', 'AccueilController@index');


Route::dispatch();


