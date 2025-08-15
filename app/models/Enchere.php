<?php
namespace App\Models;
use App\Models\CRUD;

class Enchere extends CRUD {
    protected $table = "enchere";
    protected $clePrimaire = "id";
    protected $colonnes = ['id', 'dateDebut', 'dateFin', 'prixPlancher', 'coupCoeurLord', 'timbreId'];

    public function statutEnchere($enchere){
        

    }
}