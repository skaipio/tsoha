<?php

require '../models/personnelcategory.php';
require "../libs/common.php";


if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $id = $_GET['id'];
        if (isset($id)) {            
            $employee = Employee::getEmployeeByID($id);
            $prcategory = Personnelcategory::getPersonnelCategoryById($employee->getPersonnelCategoryID());
            showView("views/showEmployee.php", array('admin'=>true, 'employee'=>$employee, 'personnelCategory'=>$prcategory));
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    redirectTo('../kirjautuminen.php');
}
