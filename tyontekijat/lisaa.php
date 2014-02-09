<?php
require "../libs/common.php";

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = getSubmittedEmployeeData();
            $employee = Employee::createEmployeeFromData((object) $data);
            if ($employee->isValid()) {
                $employee->addToDatabase();
                setSuccesses(array("Uusi työntekijä on onnistuneesti lisätty tietokantaan."));
                redirectTo('index.php');
            } else {
                setErrors($employee->getErrors());
                showView("views/addEmployee.php", array('personnelcategories' => $prcategories) + $data);
            }
        }else{
            showView('views/addEmployee.php', array('isadmin' => $admin, 'personnelcategories' => $prcategories));
        }        
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate(array('admin' => $user->isAdmin()));
    }
} else {
    redirectTo('../kirjautuminen.php');
}

