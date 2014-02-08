<?php

require_once 'libs/common.php';
require_once 'models/personnelcategory.php';

if (isLoggedIn()) {

    
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    if ($admin) {
        $employeeObjects = Employee::getEmployees();
        $employees = array();
        foreach ($employeeObjects as $employee) {
            $employees[] = getEmployeeDetailsObject($employee);
        }
        showView('views/employeesListing.php', array('isadmin' => $admin, 'employeeDetails' => $employees));
    } else {
        echo "Sivu vaatii ylläpito-oikeudet.";
        //header('Location: omattyovuorot.php');
    }
} else {
    header('Location: kirjautuminen.php');
}





