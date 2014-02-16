<?php

require "../controllers/urgencyCategoryController.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        UrgencyCategoryController::add();
    }
    $urgencyCategory = UrgencyCategoryController::createEmptyUrgencyCategory();
    showView('views/urgencyCategoryCreation.php', array('admin' => true,
        'modify' => $urgencyCategory, 'formTitle' => 'Kiireellisyyskategorian lisäys'));
} 

