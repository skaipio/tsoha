<?php

class UrgencyCategory {

    private $errors = array();
    private $id;
    private $name;
    private $minimumPersonnels = array();

    public function getErrors() {
        return $this->errors;
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMinimumPersonnels() {
        return $this->minimumPersonnels;
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
        if (empty($name)) {
            $this->errors['emptyName'] = 'Nimi ei voi olla tyhjä.';
        } else {
            unset($this->errors['emptyName']);
        }
    }

    public function setMinimumPersonnels($minimumPersonnels) {
        $this->minimumPersonnels = $minimumPersonnels;
    }
    
    public function addMinimumPersonnel($key, $minimumPersonnel) {
        $this->minimumPersonnels[$key] = $minimumPersonnel;
    }

    public function isValid() {
        return empty($this->errors);
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

    public static function getUrgencyCategoriesArray() {
        $urgencyCategories = UrgencyCategory::getUrgencyCategories();

        $urgencyCategoriesArray = array();

        foreach ($urgencyCategories as $urgencyCategory) {
            $urgencyCategoriesArray[$urgencyCategory->getID()] = $urgencyCategory;
        }

        return $urgencyCategoriesArray;
    }

    public static function getWithMinimumsAndPersonnelCategoryNames() {
        $sql = "SELECT urgencycategory.id as ucid, urgencycategory.name as ucname,"
                . "personnelcategory.id as pcid, personnelcategory.name as pcname, minimum FROM "
                . "urgencycategory, minimumpersonnel, personnelcategory WHERE "
                . "urgencycategory.id = minimumpersonnel.urgencycategory_id AND "
                . "personnelcategory.id = minimumpersonnel.personnelcategory_id";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            if (!isset($results[$result->ucid])){
                $uc = new UrgencyCategory();
                $uc->setName($result->ucname);
                $uc->setId($result->ucid);
                $results[$result->ucid] = $uc;
            }
            $results[$result->ucid]->addMinimumPersonnel($result->pcid, $result->minimum);
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
        $urgencycategory->setId($data->id);
        $urgencycategory->setName($data->name);
        return $urgencycategory;
    }

    public static function removeFromDatabase($id) {
        $sql = "DELETE FROM urgencycategory WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        return $query->execute(array($id));
    }

}
