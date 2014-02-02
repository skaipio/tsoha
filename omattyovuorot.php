<?php
require_once 'libs/common.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $admin = $user->isAdmin();
    //$firstname = "Antero";
    showView('views/employeeworkshifthours.php',
            array('firstname' => $firstname, 'lastname' => $lastname, 'isadmin' => $admin));
} else {
    header('Location: kirjautuminen.php');
}

