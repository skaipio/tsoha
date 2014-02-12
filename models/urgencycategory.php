<?php

class UrgencyCategory {

    private $id;
    private $name;

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAsDataArray() {
        return array('id' => $this->getID(), 'name' => $this->getName());
    }

    private function setId($id) {
        $this->id = $id;
    }

    private function setName($name) {
        $this->name = $name;
    }
    
    public function setFromDataObject($data) {
        if (is_object($data) && count($data)) {
            $valid = get_class_vars(get_class($this));
            foreach ($valid as $var => $val) {
                if (isset($data->$var)) {
                    //$this->$var = $data[$var];
                    call_user_func(array($this, 'set' . ucfirst($var)), $data->$var);
                }
            }
        }
    }
    
    public function addToDatabase() {
        $sql = "INSERT INTO urgencycategory(name) VALUES (?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $data = $this->getAsDataArray();
        unset($data['id']);
        $ok = $query->execute(array_values($data));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public static function getUrgencyCategories() {
        $sql = "SELECT * from urgencycategory";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = UrgencyCategory::createFromData($result);
        }
        return $results;
    }
    
//    public static function getMinimumPersonnelDataObject() {
//        $sql = "SELECT * FROM minimumpersonnel WHERE urgencycategory_id = ?";
//        $query = getDatabaseConnection()->prepare($sql);
//        $query->execute(array($this->getID()));
//
//        $result = $query->fetchObject();
//        if ($result == null) {
//            return null;
//        } else {
//            $personnelcategory = new Personnelcategory($result->id, $result->name);
//            return $personnelcategory;
//        }
//    }
    
    public static function createFromData($data) {
        $urgencycategory = new UrgencyCategory();
        $urgencycategory->setFromDataObject((object)$data);
        return $urgencycategory;
    }

    

}
