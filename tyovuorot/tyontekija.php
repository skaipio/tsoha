<?php

require '../controllers/shiftCalendarController.php';

if (loggedInAsUser()) {
    $shiftCalendarController = new ShiftCalendarController();
    
    if (isset($_GET['previousWeek'])) {
        $shiftCalendarController->employeePreviousWeek();
    } else if (isset($_GET['nextWeek'])) {
        $shiftCalendarController->employeeNextWeek();
    }
    
    $shiftCalendarController->employeeShifts();
} else {
    redirectTo('../index.php');
}