<?php

require_once 'libs/common.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesAsDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = getSubmittedEmployeeData();
            $employee = Employee::createEmployeeFromData((object)$data);
            if ($employee->isValid()){
                $employee->addToDatabase();              
                $_SESSION['notification'] = "Työntekijä on lisätty tietokantaan.";
                header('Location: tyontekijat.php');    
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

