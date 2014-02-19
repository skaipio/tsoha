<?php

require '../models/personnelcategory.php';
require "../libs/common.php";

if (loggedInAsAdmin()) {
    setNavBarAsVisible(false);

    $prcategories = Personnelcategory::getPersonnelCategories();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $employee = $_SESSION['employeeBeingModified'];
        $data = getSubmittedEmployeeData();
        $employee->setFromDataObject((object) $data);

        if ($employee->isValid()) {
            if ($employee->updateDatabaseEntry()) {
                unset($_SESSION['employeeBeingModified']);
                $id = $employee->getID();
                setSuccesses(array("Työntekijää on onnistuneesti muokattu."));
                redirectTo("nayta.php?id=$id");
            } else {
                setErrors(array("Tyontekijän muokkaus epäonnistui"));
                showView("views/employeeCreation.php", array('admin' => true, 'employee' => $employee,
                    'personnelCategories' => $prcategories, 'formTitle' => 'Tyontekijän muokkaus'));
            }
        } else {
            $data['id'] = $employee->getID();
            setErrors($employee->getErrors());
            showView("views/employeeCreation.php", array('admin' => true, 'employee' => $employee,
                'personnelCategories' => $prcategories, 'formTitle' => 'Tyontekijän muokkaus'));
        }
    }
    $employee = $_SESSION['employeeBeingModified'];

    if (!isset($employee)) {
        $id = $_GET['id'];
        if (isset($id)) {
            $employee = Employee::getEmployeeByID($id);
            $_SESSION['employeeBeingModified'] = $employee;
        } else {
            setErrors("Tyontekijää numero $id ei löytynyt tietokannasta.");
            redirectTo('index.php');
        }
    }
    
    showView("views/employeeCreation.php", array('admin' => true, 'employee' => $employee,
        'personnelCategories' => $prcategories, 'formTitle' => 'Tyontekijän muokkaus'));
} else {
    setErrors(array("Sivu vaatii ylläpito-oikeudet."));
    redirectTo('../kirjautuminen.php');
}
