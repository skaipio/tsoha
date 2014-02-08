<?php
require_once 'libs/common.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = getSubmittedEmployeeData();
            $employee = Employee::createEmployeeFromData((object)$data);
            if ($employee->isValid()){
                $employee->addToDatabase();                             
                header('Location: tyontekijat.php');    
                $_SESSION['notification'] = "Uusi työntekijä on onnistuneesti lisätty tietokantaan.";
            }else{
                showView("views/addEmployee.php", array('personnelcategories' => $prcategories, 'errors'=>$employee->getErrors()) + $data);
            }           
        }
        showView('views/addEmployee.php', array('isadmin' => $admin, 'personnelcategories' => $prcategories));
    } else {
        echo "Sivu vaatii ylläpito-oikeudet.";
    }
} else {
    header('Location: kirjautuminen.php');
}

