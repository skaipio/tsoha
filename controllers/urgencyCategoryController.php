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
        $this->errors = array();
        $urgencyCategorySubmission = $this->getSubmittedUrgencyCategory();
        $minimumPersonnels = $urgencyCategorySubmission->getMinimumPersonnels();

        if (!$urgencyCategorySubmission->isValid()) {
            $this->errors = $urgencyCategorySubmission->getErrors();
        }

        foreach ($minimumPersonnels as $minimumPersonnel) {
            $minimumPersonnel->setUrgencycategory_id($urgencyCategorySubmission->getID());
            var_dump($minimumPersonnel);
            if (!$minimumPersonnel->isValid()) {
                $this->errors = $this->errors + $minimumPersonnel->getErrors();
            }
        }

        if (empty($this->errors)) {
            $urgencyCategorySubmission->addToDatabase();
            foreach ($minimumPersonnels as $minimumPersonnel) {
                $minimumPersonnel->setUrgencycategory_id($urgencyCategorySubmission->getID());
                $minimumPersonnel->addToDatabase();
            }
        }

        $_SESSION['urgencyCategory'] = $urgencyCategorySubmission;
    }

    public function modify() {
        $urgencyCategorySubmission = $this->getSubmittedUrgencyCategoryDataObject();

        $ucBeingModified = $_SESSION['urgencyCategoryModified']->urgencyCategory;
        $ucBeingModified->setFromDataObject($urgencyCategorySubmission);

        $errors = array();

        if (!$ucBeingModified->isValid()) {
            $errors = $ucBeingModified->getErrors();
        } else if ($ucBeingModified->updateDatabaseEntry()) {
            $minimumpSubmission = $this->getSubmittedMinimumPersonnelsWithPersonnelCategories();
            foreach ($minimumpSubmission as $submission) {
                $minimumPersonnel = $submission->minimumPersonnel;
                $dbMinimumPersonnel = MinimumPersonnel::getMinimumPersonnelByUrgencyAndPersonnelCategory(
                                $ucBeingModified->getID(), $minimumPersonnel->getPersonnelCategoryId());

                $dbMinimumPersonnel->setMinimum($minimumPersonnel->getMinimum());

                if ($dbMinimumPersonnel->isValid()) {
                    $dbMinimumPersonnel->updateDatabaseEntry();
                } else {
                    $errors = $errors + $dbMinimumPersonnel->getErrors();
                }
            }
        }

        $this->urgencyCategory = (object) array('urgencyCategory' => $ucBeingModified, 'minimumPersonnels' => $minimumpSubmission);

        return $errors;
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

    public static function getPersonnelCategoriesAndMinimumPersonnelsOfUrgencyCategory($id) {
        $paired = array();
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        foreach ($personnelCategories as $personnelCategory) {
            $minimumPersonnel = MinimumPersonnel::getMinimumPersonnelByUrgencyAndPersonnelCategory($id, $personnelCategory->getID());
            $paired[] = (object) array('personnelCategory' => $personnelCategory, 'minimumPersonnel' => $minimumPersonnel);
        }
        return $paired;
    }

    private function getSubmittedUrgencyCategory() {
        $urgencyCategory = new UrgencyCategory();

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
            $minimp->setMinimum((int)$minimum);

            $minimumPersonnels[] = $minimp;
        }

        return $urgencyCategory;
    }

}
