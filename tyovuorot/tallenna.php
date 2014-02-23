<?php

require '../controllers/shiftCalendarController.php';

if (loggedInAsAdmin()) {
    $shiftCalendarController = new ShiftCalendarController();
    
    $shiftCalendarController->submit();
    redirectTo('index.php');
} else {
    redirectTo('../index.php');
}


