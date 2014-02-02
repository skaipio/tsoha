<?php
require_once 'topnavbar.php';
$tyontekijat = Employee::getEmployees();

foreach ($tyontekijat as $tyontekija) {
    echo $tyontekija->getEmail();
}

