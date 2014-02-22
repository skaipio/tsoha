<?php

require '../controllers/openHourController.php';

if (loggedInAsAdmin()) {
    $openHourController = new OpenHourController();

    if (isset($_GET['previousWeek'])) {
        $openHourController->previousWeek();
    } else if (isset($_GET['nextWeek'])) {
        $openHourController->nextWeek();
    }

    $openHourController->index();
} else {
    redirectTo('../index.php');
}