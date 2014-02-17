<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $controller = new UrgencyCategoryController();   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = $controller->add();

        if (empty($errors)) {
            setSuccesses(array("Kiireellisyyskategoria on onnistuneesti lisätty tietokantaan."));
            redirectTo('index.php');
        } else {
            setErrors($errors);
            showView('views/urgencyCategoryCreation.php', array('admin' => true,
                'modify' => $controller->getUrgencyCategory(), 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        }
        
    }
    
    $urgencyCategory = UrgencyCategoryController::createEmptyUrgencyCategory();
    showView('views/urgencyCategoryCreation.php', array('admin' => true,
        'modify' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian lisäys'));
} 

