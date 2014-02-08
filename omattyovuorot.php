<?php
require_once 'libs/common.php';
require_once 'models/personnelcategory.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    
    showView('views/employeeworkshifthours.php',
            array('isadmin' => $admin, 'employeeDetails'=>getEmployeeDetailsObject($user)));
} else {
    header('Location: kirjautuminen.php');
}

