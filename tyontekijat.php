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
            $personnelcategory = Personnelcategory::getPersonnelCategoryById($employee->getPersonnelCategoryID());
            $employees[] = (object)array('firstname'=>$employee->getFirstName(), 'lastname'=>$employee->getLastName(),
                'personnelcategory'=>$personnelcategory->getName(), 'id'=>$employee->getID());
        }
        showView('views/employeesListing.php', array('admin'=>$admin, 'employeeDetails' => $employees, 'includeNavBar'=>1));
    } else {
        echo "Sivu vaatii ylläpito-oikeudet.";
        //header('Location: omattyovuorot.php');
    }
} else {
    header('Location: kirjautuminen.php');
}





