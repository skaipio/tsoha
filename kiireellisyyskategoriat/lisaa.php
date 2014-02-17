<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $controller = new UrgencyCategoryController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->add();

        $errors = $controller->getErrors();      

        if (empty($errors)) {
            setSuccesses(array("Kiireellisyyskategoria on onnistuneesti lisätty tietokantaan."));
            redirectTo('index.php');
        } else {
            setErrors($errors);
            $urgencyCategory = $controller->getUrgencyCategory();
            showView('views/urgencyCategoryCreation.php', array('admin' => true,
                'urgencyCategory' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        }
    }

    $urgencyCategory = UrgencyCategoryController::createEmptyUrgencyCategory();
    $personnelCategories = Personnelcategory::getPersonnelCategories();
    showView('views/urgencyCategoryCreation.php', array('admin' => true,
        'urgencyCategory' => $urgencyCategory, 'personnelCategories' => $personnelCategories, 'formTitle' => 'Kiireellisyyskategorian lisäys'));
} 

