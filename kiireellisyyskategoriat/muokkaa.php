<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $controller = new UrgencyCategoryController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->modify();

        $errors = $controller->getErrors();

        if (empty($errors)) {
            setSuccesses(array("Kiireellisyyskategoriaa on onnistuneesti muokattu."));
            redirectTo('index.php');
        } else {
            setErrors($errors);
            $urgencyCategory = $controller->getUrgencyCategory();
            showView('views/urgencyCategoryCreation.php', array('admin' => true,
                'urgencyCategory' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
        }
    }

    $id = $_GET['id'];
    if (empty($id)) {
        redirectTo('index.php');
    }
    
    $urgencyCategory = UrgencyCategoryController::getUrgencyCategoryWithMinimumPersonnels($id);
    if (!isset($urgencyCategory)) {
        setErrors(array('Kiireellisyyskategoriaa ei löytynyt tietokannasta.'));
        redirectTo('index.php');
    }

    $_SESSION['urgencyCategory'] = $urgencyCategory;

    showView('views/urgencyCategoryCreation.php', array('admin' => true,
        'urgencyCategory' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
}else{
    $errors = array("Sivu vaatii ylläpito-oikeudet.");
    setErrors($errors);
    redirect('../index.php');
}

