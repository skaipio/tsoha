<?php

require '../controllers/openHourController.php';

if (loggedInAsAdmin()) {
    $openHourController = new OpenHourController();
    
    $openHourController->submit();
    redirectTo('index.php');
} else {
    redirectTo('../index.php');
}

