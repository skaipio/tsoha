<?php
require 'libs/common.php';

$user = getUserLoggedIn();
if (isset($user)) {   
    setNavBarAsVisible(true);
    $admin = $user->isAdmin();
    if ($admin) {
        $employeeObjects = Employee::getEmployees();
        $employees = array();
        foreach ($employeeObjects as $employee) {
            $personnelcategory = Personnelcategory::getPersonnelCategoryById($employee->getPersonnelCategoryID());
            $employees[] = (object)array('firstname'=>$employee->getFirstName(), 'lastname'=>$employee->getLastName(),
                'personnelcategory'=>$personnelcategory->getName(), 'id'=>$employee->getID());
        }
        showView('views/employeesListing.php', array('admin'=>$admin, 'employeeDetails' => $employees));
    } else {
        $warnings = array("Sivu vaatii ylläpito-oikeudet.");
        setErrors($warnings);
        showOnlyTemplate(array('admin'=>$user->isAdmin()));
    }
} else {
    header('Location: kirjautuminen.php');
}





