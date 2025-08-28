<?php
namespace App\Models;

// abstract veut dire que CRUD ne peut pas etre instancer. Peux juste etre extend.
abstract class CRUD extends \PDO{

    public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=stampee;port=3306;charset=utf8', 'root', 'admin');
       // parent::__construct('mysql:host=localhost;dbname=e2496543;port=3306;charset=utf8', 'e2496543', 'XvPSh12zpRH7cNniPCcz');
    }

    public function select($champ = null, $order='asc'){
        if($champ == null){
            $champ = $this->clePrimaire;
        }
        $sql = "SELECT * FROM $this->table ORDER BY $champ $order";
         if($stmt = $this->query($sql)){
            return $stmt->fetchAll();
        }else{
            return false;
        }
    }

    public function selectId($value){
        $sql = "SELECT * FROM  $this->table WHERE $this->clePrimaire = :$this->clePrimaire";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->clePrimaire", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        } 
    }

    final public function selectDoubleId($valueId1, $valueId2)
    {
        $sql = "SELECT * FROM $this->table WHERE $this->clePrimaire = :$this->clePrimaire and $this->secondId = :$this->secondId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->clePrimaire", $valueId1);
        $stmt->bindValue(":$this->secondId", $valueId2);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $count = count($rows);
        if ($count == 1) {
            return $rows[0];
        } else {
            return false;
        }
    }

 

       public function selectWhere($value, $champ, $columns = '*', $order='asc'){
        $sql = "SELECT $columns FROM $this->table WHERE $champ = :$champ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$champ", $value);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data){
        $data_keys = array_fill_keys($this->colonnes, '');
        $data = array_intersect_key($data, $data_keys);
        $champName = implode(', ', array_keys($data));
        $champValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($champName) VALUES ($champValue);";
        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId() ?: true;
        }else{
            return false;
        } 
    }

    public function update($data, $id){
        $data_cles = array_fill_keys($this->colonnes, '');
        $data = array_intersect_key($data, $data_cles);
        
        $champName = null;
        foreach($data as $cle=>$valeur){
            $champName .= "$cle = :$cle, ";
        }
        $champName = rtrim($champName, ', ');
        
        $sql = "UPDATE $this->table SET $champName WHERE $this->clePrimaire = :$this->clePrimaire";
        $data[$this->clePrimaire] = $id;
        $stmt = $this->prepare($sql);
        
        foreach($data as $cle=>$valeur){
            $stmt->bindValue(":$cle", $valeur);
        }
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($value){
        $sql = "DELETE FROM $this->table WHERE $this->clePrimaire = :$this->clePrimaire";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->clePrimaire", $value);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    final public function deleteDoubleId($valueId1, $valueId2)
    {
        $sql = "DELETE FROM $this->table WHERE  $this->clePrimaire = :$this->clePrimaire and $this->secondId = :$this->secondId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->clePrimaire", $valueId1);
        $stmt->bindValue(":$this->secondId", $valueId2);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
 

    public function unique($champ, $valeur){
        $sql = "SELECT * FROM $this->table WHERE $champ = :$champ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$champ", $valeur);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }

    }
}