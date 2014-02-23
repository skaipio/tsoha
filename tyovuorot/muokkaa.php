<?php

require '../controllers/shiftCalendarController.php';

if (loggedInAsAdmin()) {
    $shiftCalendarController = new ShiftCalendarController();
    $shiftCalendarController->modify();
} else {
    redirectTo('../index.php');
}