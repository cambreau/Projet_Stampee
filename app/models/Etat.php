<?php
namespace App\Models;
use App\Models\CRUD;

class Etat extends CRUD {
    protected $table = "etat";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'nom'];
}