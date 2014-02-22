<?php

require '../controllers/shiftCalendarController.php';

if (loggedInAsAdmin()) {
    $shiftCalendarController = new ShiftCalendarController();

    if (isset($_GET['previousWeek'])) {
        $shiftCalendarController->previousWeek();
    } else if (isset($_GET['nextWeek'])) {
        $shiftCalendarController->nextWeek();
    }

    $shiftCalendarController->index();
} else {
    redirectTo('../index.php');
}