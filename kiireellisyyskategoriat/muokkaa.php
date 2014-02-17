<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);
    
    $controller = new UrgencyCategoryController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = $controller->modify();
        
        if (!empty($errors)) {
            setErrors($errors);
            showView('views/urgencyCategoryCreation.php', array('admin' => true,
                'modify' => $controller->getUrgencyCategory(), 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        } else {
            setSuccesses(array("Kiireellisyyskategoriaa on onnistuneesti muokattu."));
            redirectTo('index.php');
        }
    }

    $id = $_GET['id'];
    if (empty($id)) {
        redirectTo('index.php');
    }
    $ucBeingModified = UrgencyCategory::getByID($id);
    if (empty($ucBeingModified)) {
        setErrors(array('Kiireellisyyskategoriaa ei löytynyt tietokannasta.'));
        redirectTo('index.php');
    }
    
    $urgencyCategory = (object)array('urgencyCategory'=>$ucBeingModified, 'minimumPersonnels'=>
        UrgencyCategoryController::getPersonnelCategoriesAndMinimumPersonnelsOfUrgencyCategory($ucBeingModified->getID()));
    
    $_SESSION['urgencyCategoryModified'] = $urgencyCategory;

    showView('views/urgencyCategoryCreation.php', array('admin' => true,
        'modify' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
}

