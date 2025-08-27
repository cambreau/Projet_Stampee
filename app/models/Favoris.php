<?php
namespace App\Models;
use App\Models\CRUD;

class Favoris extends CRUD {
    protected $table = "favoris";
    protected $clePrimaire = "Membre_id";
    protected $colonnes = ['Membre_id', 'Enchere_id'];
}