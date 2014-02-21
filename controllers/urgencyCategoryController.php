<?php

require '../models/personnelcategory.php';
require '../models/urgencycategory.php';

class UrgencyCategoryController {

    private $urgencyCategory;
    private $errors = array();

    public function getUrgencyCategory() {
        return $this->urgencyCategory;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getUrgencyCategoryList() {
        $urgencyCategories = UrgencyCategory::getUrgencyCategories();

        // Pair Urgency Categories with their respective minimum personnel demands.
        foreach ($urgencyCategories as $urgencyCategory) {
            $minimumPersonnels = MinimumPersonnel::getMinimumPersonnelByUrgencyCategory($urgencyCategory->getID());
            $urgencyCategory->setMinimumPersonnels($minimumPersonnels);
        }

        return $urgencyCategories;
    }

    public function add() {
        $urgencyCategorySubmission = UrgencyCategoryController::getSubmittedUrgencyCategory();

        if (!$urgencyCategorySubmission->isValid()) {
            $this->errors = $urgencyCategorySubmission->getErrors();
        }

        $minimumPersonnels = $urgencyCategorySubmission->getMinimumPersonnels();

        $this->errors = $this->errors + validate($minimumPersonnels);

        if (empty($this->errors)) {
            $urgencyCategorySubmission->addToDatabase();
            $minimumPersonnels = $urgencyCategorySubmission->getMinimumPersonnels();
            foreach ($minimumPersonnels as $minimumPersonnel) {
                $minimumPersonnel->setUrgencycategory_id($urgencyCategorySubmission->getID());
                if (!$minimumPersonnel->addToDatabase()) {
                    $this->errors = $this->errors + array('Minimivahvuutta ei voitu lisätä tietokantaan.');
                }
            }
        }

        $this->urgencyCategory = $urgencyCategorySubmission;
    }
    
    

    public function modify() {
        $urgencyCategory = UrgencyCategoryController::getSubmittedUrgencyCategory();

        $errors = array();

        if (!$urgencyCategory->isValid()) {
            $errors = $urgencyCategory->getErrors();
        }

        $minimumPersonnels = $urgencyCategory->getMinimumPersonnels();
        $errors = $errors + validate($minimumPersonnels);
        
        if (empty($errors)) {
            $urgencyCategory->updateDatabaseEntry();
            $minimumPersonnels = $urgencyCategory->getMinimumPersonnels();
            foreach ($minimumPersonnels as $minimumPersonnel) {
                $minimumPersonnel->setUrgencycategory_id($urgencyCategory->getID());
                if (!$minimumPersonnel->updateDatabaseEntry()) {
                    $errors = $errors + array('Minimivahvuutta ei voitu lisätä tietokantaan.');
                }
            }
        }

        $this->errors = $errors;
        $this->urgencyCategory = $urgencyCategory;
        $_SESSION['urgencyCategory'] = $urgencyCategory;
    }
    
    public function submit(){
        
    }

    public static function createEmptyUrgencyCategory() {
        $urgencyCategory = new UrgencyCategory();
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        $minimumPersonnels = array();
        foreach ($personnelCategories as $personnelCategory) {
            $minimp = new MinimumPersonnel();
            $minimp->setMinimum(0);
            $minimp->setPersonnelcategory_id($personnelCategory->getID());
            $minimp->setPersonnelCategory($personnelCategory);
            $minimumPersonnels[] = $minimp;
        }
        $urgencyCategory->setMinimumPersonnels($minimumPersonnels);
        return $urgencyCategory;
    }
    
    public static function getUrgencyCategoryWithMinimumPersonnels($id){
        $urgencyCategory = UrgencyCategory::getByID($id);
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        $minimumPersonnels = array();
        
        foreach ($personnelCategories as $personnelCategory){
            $minimumPersonnel = MinimumPersonnel::getMinimumPersonnelByUrgencyAndPersonnelCategory($id, $personnelCategory->getID());
            $minimumPersonnel->setPersonnelCategory($personnelCategory);
            $minimumPersonnels[] = $minimumPersonnel;
        }
        
        $urgencyCategory->setMinimumPersonnels($minimumPersonnels);
        return $urgencyCategory;
    }

    private static function getSubmittedUrgencyCategory() {
        if (isset($_SESSION['urgencyCategory'])) {
            $urgencyCategory = $_SESSION['urgencyCategory'];
        } else {
            $urgencyCategory = new UrgencyCategory();
        }
        $name = $_POST['name'];
        $urgencyCategory->setName($name);

        $minimumPersonnels = $urgencyCategory->getMinimumPersonnels();
        $personnelCategories = Personnelcategory::getPersonnelCategories();

        foreach ($personnelCategories as $personnelCategory) {
            $minimp = new MinimumPersonnel();
            $minimp->setPersonnelCategory($personnelCategory);

            $pcID = $personnelCategory->getID();
            $minimp->setPersonnelcategory_id($pcID);

            $minimum = $_POST["minimum_of_$pcID"];
            $minimp->setMinimum((int) $minimum);

            $minimumPersonnels[] = $minimp;
        }

        $urgencyCategory->setMinimumPersonnels($minimumPersonnels);
        return $urgencyCategory;
    }

}
