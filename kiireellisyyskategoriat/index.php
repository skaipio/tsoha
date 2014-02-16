<?php

require '../libs/common.php';
require '../controllers/urgencyCategoryController.php';
require '../models/minimumpersonnel.php';


if (loggedInAsAdmin()) {
    setNavBarAsVisible(true);

    UrgencyCategoryController::listAll();
}






