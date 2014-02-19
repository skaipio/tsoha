<?php

require '../models/personnelcategory.php';
require "../libs/common.php";

if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $prcategories = getPersonnelCategories();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = getSubmittedEmployeeData();
        $employee = Employee::createEmployeeFromData($data);
        if ($employee->isValid()) {
            $employee->addToDatabase();
            setSuccesses(array("Uusi työntekijä on onnistuneesti lisätty tietokantaan."));
            redirectTo('index.php');
        } else {
            setErrors($employee->getErrors());
            showView("views/employeeCreation.php", array('personnelcategories' => $prcategories, 'formTitle' => 'Uuden tyontekijän lisäys') + $data);
        }
    }
    showView('views/employeeCreation.php', array('admin' => $admin, 'personnelCategories' => $prcategories, 'formTitle' => 'Uuden tyontekijän lisäys'));
}


