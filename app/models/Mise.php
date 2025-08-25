<?php
namespace App\Models;
use App\Models\CRUD;

class Mise extends CRUD {
    protected $table = "mise";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'membreId', 'enchereId', 'prix', 'date'];

}