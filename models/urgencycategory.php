<?php

class UrgencyCategory {

    private $errors = array();
    private $id;
    private $name;

    public function getErrors() {
        return $this->errors;
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    private function setId($id) {
        $this->id = $id;
    }

    private function setName($name) {
        $this->name = $name;
        if(empty($name)){
            $this->errors['emptyName'] = 'Nimi ei voi olla tyhjä.';
        }else{
            unset($this->errors['emptyName']);
        }
    }

    public function isValid() {
        return empty($this->errors);
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
        $ok = $query->execute(array($this->getName()));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public function updateDatabaseEntry() {
        $sql = "UPDATE urgencycategory SET name=? WHERE id=?";
        $query = getDatabaseConnection()->prepare($sql);
        return $query->execute(array($this->getName(), $this->getID()));
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

    public static function getByID($id) {
        $sql = "SELECT * FROM urgencycategory WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($id));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            return UrgencyCategory::createFromData($result);
        }
    }

    public static function createFromData($data) {
        $urgencycategory = new UrgencyCategory();
        $urgencycategory->setFromDataObject((object) $data);
        return $urgencycategory;
    }

    public static function removeFromDatabase($id) {
        $sql = "DELETE FROM urgencycategory WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        return $query->execute(array($id));
    }

}
