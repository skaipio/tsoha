<?php

require '../models/personnelcategory.php';
require '../models/urgencycategory.php';

class UrgencyCategoryController {

    private $urgencyCategory;

    public function getUrgencyCategory() {
        return $this->urgencyCategory;
    }

    public function getUrgencyCategoryList() {
        $urgencyCategories = UrgencyCategory::getUrgencyCategories();
        $urgencyCategoriesWithMinimumPersonnels = array();

        // Pair Urgency Categories with their respective minimum personnel demands.
        foreach ($urgencyCategories as $urgencyCategory) {
            $minimumpersonnels = MinimumPersonnel::getMinimumPersonnelByUrgencyCategory($urgencyCategory->getID());
            $paired = UrgencyCategoryController::urgencyCategoryWithMinimumPersonnels($urgencyCategory, $minimumpersonnels);
            $urgencyCategoriesWithMinimumPersonnels[] = $paired;
        }

        return $urgencyCategoriesWithMinimumPersonnels;
    }

    public function add() {
        $urgencyCategorySubmission = $this->getSubmittedUrgencyCategoryDataObject();

        $ucBeingModified = UrgencyCategory::createFromData($urgencyCategorySubmission);
        $minimumpSubmission = $this->getSubmittedMinimumPersonnelsWithPersonnelCategories();

        $errors = array();

        if (!$ucBeingModified->isValid()) {
            $errors = $ucBeingModified->getErrors();
        } else if ($ucBeingModified->addToDatabase()) {
            foreach ($minimumpSubmission as $submission) {
                $minimumPersonnel = $submission->minimumPersonnel;
                $minimumPersonnel->setUrgencycategory_id($ucBeingModified->getID());

                if (!$minimumPersonnel->isValid()) {
                    $errors = $errors + $minimumPersonnel->getErrors();
                } else {
                    $minimumPersonnel->addToDatabase();
                }
            }
        }

        $this->urgencyCategory = (object) array('urgencyCategory' => $ucBeingModified, 'minimumPersonnels' => $minimumpSubmission);

        return $errors;
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
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        $minimumPersonnels = array();
        foreach ($personnelCategories as $personnelCategory) {
            $minimp = new MinimumPersonnel();
            $minimumPersonnels[] = UrgencyCategoryController::minimumPersonnelWithPersonnelCategory($minimp, $personnelCategory);
        }
        return UrgencyCategoryController::urgencyCategoryWithMinimumPersonnels(new UrgencyCategory(), $minimumPersonnels);
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

    private static function minimumPersonnelWithPersonnelCategory($minimumPersonnel, $personnelCategory) {
        return (object) array('minimumPersonnel' => $minimumPersonnel, 'personnelCategory' => $personnelCategory);
    }

    private static function urgencyCategoryWithMinimumPersonnels($urgencyCategory, $minimumPersonnels) {
        return (object) array('urgencyCategory' => $urgencyCategory, 'minimumPersonnels' => $minimumPersonnels);
    }

    private function getSubmittedUrgencyCategoryDataObject() {
        $name = $_POST['name'];
        $personnelcategories = Personnelcategory::getPersonnelCategories();
        $minimums = array();
        foreach ($personnelcategories as $pc) {
            $pcid = $pc->getID();
            $minimum = $_POST["minimum_of_$pcid"];
            if (isset($minimum)) {
                $minimums[$pcid] = $minimum;
            }
        }
        $data = array('name' => $name, 'minimums' => (object) $minimums);
        return (object) $data;
    }

    private function getSubmittedMinimumPersonnelsWithPersonnelCategories() {
        $minimumPersonnels = array();
        $personnelCategories = Personnelcategory::getPersonnelCategories();

        foreach ($personnelCategories as $personnelCategory) {
            $pcID = $personnelCategory->getID();
            $minimum = $_POST["minimum_of_$pcID"];

            $minimp = new MinimumPersonnel();
            if (isset($minimum)) {
                $minimp->setMinimum($minimum);
            }
            $minimp->setPersonnelcategory_id($pcID);
            $minimumPersonnels[] = (object) array('minimumPersonnel' => $minimp, 'personnelCategory' => $personnelCategory);
        }

        return $minimumPersonnels;
    }

}
