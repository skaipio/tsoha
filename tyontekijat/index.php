<?php
require '../libs/common.php';

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
        $errors = array("Sivu vaatii ylläpito-oikeudet.");
        setErrors($errors);
        showOnlyTemplate(array('admin'=>$user->isAdmin()));
    }
} else {
    redirectTo('../kirjautuminen.php');
}





