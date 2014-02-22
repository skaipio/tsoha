<?php
require '../controllers/openHourController.php';


if (loggedInAsAdmin()) {
    $openHourController = new OpenHourController();

    $openHourController->modify();
} else {
    redirectTo('../index.php');
}