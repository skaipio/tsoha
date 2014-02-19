<?php

require '../models/personnelcategory.php';
require "../libs/common.php";

if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $prcategories = Personnelcategory::getPersonnelCategories();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = getSubmittedEmployeeData();
        $employee = Employee::createEmployeeFromData($data);
        if ($employee->isValid()) {
            $employee->addToDatabase();
            setSuccesses(array("Uusi työntekijä on onnistuneesti lisätty tietokantaan."));
            redirectTo('index.php');
        } else {
            setErrors($employee->getErrors());
            showView("views/employeeCreation.php", array('admin'=>true, 'employee'=>$employee,
                'personnelCategories' => $prcategories, 'formTitle' => 'Uuden tyontekijän lisäys') + $data);
        }
    }
    
    $employee = new Employee();
    showView('views/employeeCreation.php', array('admin' => true, 'employee'=>$employee,
        'personnelCategories' => $prcategories, 'formTitle' => 'Uuden tyontekijän lisäys'));
}


