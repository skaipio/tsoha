<?php

require '../models/personnelcategory.php';
require '../models/urgencycategory.php';

class UrgencyCategoryController {

    public static function listAll() {
        $personnelCategories = Personnelcategory::getPersonnelCategories();

        $urgencyCategories = UrgencyCategory::getUrgencyCategories();
        $urgencyCategoriesWithMinimumPersonnels = array();

        // Pair Urgency Categories with their respective minimum personnel demands.
        foreach ($urgencyCategories as $urgencyCategory) {
            $minimumpersonnels = MinimumPersonnel::getMinimumPersonnelByUrgencyCategory($urgencyCategory->getID());
            $paired = UrgencyCategoryController::pairUrgencyCategoryAndMinimumPersonnels($urgencyCategory, $minimumpersonnels);
            $urgencyCategoriesWithMinimumPersonnels[] = $paired;
        }

        showView('views/urgencyCategoriesListing.php', array('admin' => true,
            'personnelCategories' => $personnelCategories, 'urgencyCategories' => $urgencyCategoriesWithMinimumPersonnels));
    }

    public static function add() {
        $urgencyCategorySubmission = UrgencyCategoryController::getSubmittedUrgencyCategoryDataObject();

        $ucBeingModified = UrgencyCategory::createFromData($urgencyCategorySubmission);

        $errors = array();

        if (!$ucBeingModified->isValid()) {
            $errors = $ucBeingModified->getErrors();
        } else if ($ucBeingModified->addToDatabase()) {
            $minimumpSubmission = UrgencyCategoryController::getSubmittedMinimumPersonnelDataObject();
            $minimumPersonnels = array();

            foreach ($minimumpSubmission as $pcid => $minimum) {
                $minimp = MinimumPersonnel::createFromData(array('urgencycategory_id' => $ucBeingModified->getID(),
                            'personnelcategory_id' => $pcid, 'minimum' => $minimum));
                $personnelCategory = Personnelcategory::getPersonnelCategoryById($pcid);
                $minimumPersonnels[] = (object) array('minimumPersonnel' => $minimp, 'personnelCategory' => $personnelCategory);
                if (!$minimp->isValid()) {
                    $errors = $errors + $minimp->getErrors();
                } else {
                    $minimp->addToDatabase();
                }
            }
        }

        if (empty($errors)) {
            setSuccesses(array("Kiireellisyyskategoria on onnistuneesti lisätty tietokantaan."));
            redirectTo('../kiireellisyyskategoriat/index.php');
        } else {
            setErrors($errors);
            $urgencyCategory = (object) array('urgencyCategory' => $ucBeingModified, 'minimumPersonnels' => $minimumPersonnels);
            showView('views/urgencyCategoryCreation.php', array('admin' => true,
                'modify' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        }
    }

    public static function modify($urgencyCategory) {
        $urgencyCategorySubmission = UrgencyCategoryController::getSubmittedUrgencyCategoryDataObject();

        $ucBeingModified = $_SESSION['urgencyCategoryModified']->urgencyCategory;
        $ucBeingModified->setFromDataObject($urgencyCategorySubmission);

        $minimumpSubmission = UrgencyCategoryController::getSubmittedMinimumPersonnelDataObject();

        $errors = array();

        if (!$ucBeingModified->isValid()) {
            $errors = $ucBeingModified->getErrors();
        }

        $minimumPersonnels = array();

        foreach ($minimumpSubmission as $pcid => $minimum) {
            $minimp = MinimumPersonnel::createFromData(array('urgencycategory_id' => $ucBeingModified->getID(),
                        'personnelcategory_id' => $pcid, 'minimum' => $minimum));
            $minimumPersonnels[] = $minimp;
            if ($minimp->isValid()) {
                $minimp->updateDatabaseEntry();
            } else {
                $errors = $errors + $minimp->getErrors();
            }
        }

        if (!empty($errors)) {
            setErrors($errors);
            $urgencyCategoryAndMinimumPersonnels = UrgencyCategoryController::pairUrgencyCategoryAndMinimumPersonnels($ucBeingModified, $minimp);
            showView('views/urgencyCategoryCreation.php', array('admin' => $admin,
                'urgencyCategory' => $urgencyCategoryAndMinimumPersonnels, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        } else if ($ucBeingModified->updateDatabaseEntry()) {
            setSuccesses(array("Kiireellisyyskategoriaa on onnistuneesti muokattu."));
            redirectTo('../kiireellisyyskategoriat/index.php');
        }

        setErrors(array('Kiireellisyyskategoriaa ei voitu muokata.') + $ucerror);
        showView('views/urgencyCategoryCreation.php', $ucBeingModified->getAsDataArray() + array('admin' => $admin,
            'personnelcategories' => $prcategories, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
    }

    public static function createEmptyUrgencyCategory() {
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        $minimumPersonnels = array();
        foreach ($personnelCategories as $personnelCategory) {
            $minimp = new MinimumPersonnel();
            $minimumPersonnels[] = (object) array('minimumPersonnel' => $minimp, 'personnelCategory' => $personnelCategory);
        }
        return (object) array('urgencyCategory' => new UrgencyCategory(), 'minimumPersonnels' => $minimumPersonnels);
    }

    public static function pairUrgencyCategoryAndMinimumPersonnels($urgencyCategory, $minimumpersonnels) {
        return (object) array('urgencyCategory' => $urgencyCategory, 'minimumPersonnels' => $minimumpersonnels);
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

    private static function getSubmittedUrgencyCategoryDataObject() {
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

    private static function getSubmittedMinimumPersonnelDataObject() {
        $personnelcategories = Personnelcategory::getPersonnelCategories();
        $minimums = array();
        foreach ($personnelcategories as $pc) {
            $pcid = $pc->getID();
            $minimum = $_POST["minimum_of_$pcid"];
            if (isset($minimum)) {
                $minimums[$pcid] = $minimum;
            }
        }
        return (object) $minimums;
    }

}
