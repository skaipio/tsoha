<?php
require_once 'databaseconnection.php';
require_once '../models/employee.php';
//Lista asioista array-tietotyyppiin laitettuna:
$tyontekijat = Employee::getEmployees();
?>
<!DOCTYPE HTML>
<html>
    <head><title>Otsikko</title></head>
    <body>
        <h1>Listaelementtitesti</h1>
        <ul>
            <?php foreach ($tyontekijat as $employee): ?>
            <li><?php
            $firstname = $employee->getFirstName();
            $lastname = $employee->getLastName();
            $sposti = $employee->getEmail();
            echo "$firstname $lastname, $sposti"?>
            </li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>
