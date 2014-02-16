<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        UrgencyCategoryController::modify($_SESSION['urgencyCategoryModified']);
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

    showView('views/urgencyCategoryCreation.php', array('admin' => $admin,
        'modify' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
}

