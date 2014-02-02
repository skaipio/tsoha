<?php

require_once 'libs/common.php';
//require_once 'models/tyontekija.php';

if (isLoggedIn()) {
    $user = unserialize(getUserLoggedIn());
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $admin = $user->isAdmin();
    //$firstname = "Antero";
    showView('views/employeeworkshifthours.php',
            array('firstname' => $firstname, 'lastname' => $lastname, 'isadmin' => $admin));
//    showView('views/employeeworkshifthours.php',
//            array('firstname' => $firstname, 'lastname' => $lastname));
} else {
    header('Location: kirjautuminen.php');
}

