<?php

class MinimumPersonnel {

    private $id;
    private $urgencycategory_id;
    private $personnelcategory_id;
    private $minimum;

    public function getID() {
        return $this->id;
    }

    public function getUrgencyCategoryId() {
        return $this->urgencycategory_id;
    }

    public function getPersonnelCategoryId() {
        return $this->personnelcategory_id;
    }
    
    public function getMinimum() {
        return $this->minimum;
    }

    public function getAsDataArray() {
        return array('id' => $this->getID(), 'urgencycategory_id' => $this->getUrgencyCategoryId(),
            '$personnelcategory_id' => $this->getPersonnelCategoryId(), 'minimum' => $this->getMinimum());
    }

    private function setId($id) {
        $this->id = $id;
    }

    private function setUrgencycategory_id($id) {
        $this->urgencycategory_id = $id;
    }

    private function setPersonnelcategory_id($id) {
        $this->personnelcategory_id = $id;
    }
    
    private function setMinimum($minimum) {
        $this->minimum = $minimum;
    }
    
    public function addToDatabase() {
        $sql = "INSERT INTO minimumpersonnel(urgencycategory_id, personnelcategory_id, minimum)"
                . "VALUES (?,?,?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $data = $this->getAsDataArray();
        unset($data['id']);
        $ok = $query->execute(array_values($data));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }
    
    
    public static function getMinimumPersonnelByUrgencyCategoryAndPersonnelCategory($urgencycategory_id, $personnelcategory_id) {
        $sql = "SELECT * FROM minimumpersonnel WHERE urgencycategory_id = ? AND personnelcategory_id = ? LIMIT 1";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($urgencycategory_id, $personnelcategory_id));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            return MinimumPersonnel::createFromData($result);
        }
    }

    public static function getMinimumPersonnels() {
        $sql = "SELECT * from minimumpersonnel";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = MinimumPersonnel::createFromData($result);
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
        $minimumpersonnel = new MinimumPersonnel();
        $minimumpersonnel->setFromDataObject((object) $data);
        return $minimumpersonnel;
    }

    public function setFromDataObject($data) {
        if (is_object($data) && count($data)) {
            $valid = get_class_vars(get_class($this));
            foreach ($valid as $var => $val) {
                if (isset($data->$var)) {
                    call_user_func(array($this, 'set' . ucfirst($var)), $data->$var);
                }
            }
        }
    }

}
