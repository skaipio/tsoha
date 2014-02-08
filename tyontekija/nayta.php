<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/tyovuorolista/libs/common.php";
require_once($path);

unset($_SESSION['employeeBeingModified']);

if (isLoggedIn()) {
    $user = getUserLoggedIn();
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
        echo "Sivu vaatii ylläpito-oikeudet.";
    }
} else {
    header('Location: kirjautuminen.php');
}

