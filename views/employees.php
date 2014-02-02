<?php
require_once 'topnavbar.php';
$tyontekijat = Employee::getEmployees();

foreach ($tyontekijat as $employee) {
    echo $employee->getEmail();
}

