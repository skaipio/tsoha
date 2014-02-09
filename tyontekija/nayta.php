<?php
require "../libs/common.php";

unset($_SESSION['employeeBeingModified']);

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $id = $_GET['id'];
        if (isset($id)) {            
            $employee = Employee::getEmployeeByID($id);
            $prcategory = Personnelcategory::getPersonnelCategoryById($employee->getPersonnelCategoryID());
            $employee = $employee->getAsDataArray();
            $employee['personnelcategory'] = $prcategory->getName();
            showView("views/showEmployee.php", $employee);
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    header('Location: ../kirjautuminen.php');
}

