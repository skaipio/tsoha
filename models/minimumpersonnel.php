<?php

class MinimumPersonnel {

    private $errors = array();
    private $id;
    private $urgencycategory_id;
    private $personnelcategory_id;
    private $minimum;

    public function getErrors() {
        return $this->errors;
    }

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

    public function setUrgencycategory_id($id) {
        $this->urgencycategory_id = $id;
    }

    public function setPersonnelcategory_id($id) {
        $this->personnelcategory_id = $id;
    }

    public function setMinimum($minimum) {
        if (empty($minimum)) {
            $this->errors['empty'] = "Minimi ei voi olla tyhjä. ";
        } else {
            unset($this->errors['empty']);
        }
        if (!is_numeric($minimum)) {
            $this->errors['number'] = "Minimin on oltava numero. ";
        } else {
            unset($this->errors['number']);
            if ($minimum < 0) {
                $this->errors['negative'] = "Minimin on oltava positiivinen tai nolla. ";
            } else {
                unset($this->errors['negative']);
                $this->minimum = $minimum;
            }
        }
    }

    public function isValid() {
        return empty($this->errors);
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

    public function updateDatabaseEntry() {
        $sql = "UPDATE minimumpersonnel SET minimum=? WHERE urgencycategory_id=? AND personnelcategory_id=?";
        $query = getDatabaseConnection()->prepare($sql);
        return $query->execute(array($this->getMinimum(), $this->getUrgencyCategoryId(), $this->getPersonnelCategoryId()));
    }

    public static function getMinimumPersonnelByUrgencyCategory($urgencycategory_id) {
        $sql = "SELECT * FROM minimumpersonnel WHERE urgencycategory_id = ? ORDER BY urgencycategory_id";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($urgencycategory_id));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = MinimumPersonnel::createFromData($result);
        }
        return $results;
    }

    public static function getMinimumPersonnelByUrgencyAndPersonnelCategory($urgencycategory_id, $personnelcategory_id) {
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
