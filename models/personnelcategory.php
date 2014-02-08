<?php

class Personnelcategory{
    private $id;
    private $name;
    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getID(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public static function getPersonnelCategoryById($id_){
        $sql = "SELECT id, name FROM personnelcategory WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($id_));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $personnelcategory = new Personnelcategory($result->id, $result->name);
            return $personnelcategory;
        }
    }
    
    public static function getPersonnelCategories(){
        $sql = "SELECT * from personnelcategory";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {       
            $results[] = new Personnelcategory($result->id, $result->name);
        }
        return $results;
    }
}
