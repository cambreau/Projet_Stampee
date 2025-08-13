<?php
namespace App\Models;
use App\Models\CRUD;

class Couleurs extends CRUD {
    protected $table = "couleurs";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'nom'];
}