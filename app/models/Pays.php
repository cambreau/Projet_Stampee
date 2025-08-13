<?php
namespace App\Models;
use App\Models\CRUD;

class Pays extends CRUD {
    protected $table = "pays";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'nom'];
}