<?php

require '../controllers/shiftCalendarController.php';

if (loggedInAsAdmin()) {
    $shiftCalendarController = new ShiftCalendarController();
    
    $shiftCalendarController->submit();
} else {
    redirectTo('../index.php');
}


