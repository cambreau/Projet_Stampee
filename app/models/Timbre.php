<?php
namespace App\Models;
use App\Models\CRUD;

class Timbre extends CRUD {
    protected $table = "timbre";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'nom', 'dateEmission','certifie','tirage','dimension','membreId','couleursId','paysId','etatId'];
}