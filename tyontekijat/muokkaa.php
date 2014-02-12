<?php

require "../libs/common.php";

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee = $_SESSION['employeeBeingModified'];
            $data = getSubmittedEmployeeData();
            $employee->setFromDataObject((object)$data);
            $prcategories = getPersonnelCategoriesDataArray();
            if ($employee->isValid()) {
                if ($employee->updateDatabaseEntry()) {
                    $data = $employee->getAsDataArray();
                    unset($_SESSION['employeeBeingModified']);
                    $id = $employee->getID();
                    setSuccesses(array("Työntekijää on onnistuneesti muokattu."));
                    redirectTo("nayta.php?id=$id");
                } else {
                    setErrors(array("Tyontekijän muokkaus epäonnistui"));
                    showView("views/employeeCreation.php", array('personnelcategories' => $prcategories, 'formTitle' => 'Tyontekijän muokkaus') + $data);
                }
            } else {
                $data['id'] = $employee->getID();
                setErrors($employee->getErrors());
                showView("views/employeeCreation.php", array('personnelcategories' => $prcategories) + $data);
            }
        }

        $prcategoriesData = getPersonnelCategoriesDataArray();
        $employee = $_SESSION['employeeBeingModified'];

        if (isset($employee)) {
            $employee = $employee->getAsDataArray();
            showView("views/employeeCreation.php", array('personnelcategories' => $prcategoriesData, 'formTitle' => 'Tyontekijän muokkaus') + $employee);
        } else {
            $id = $_GET['id'];
            if (isset($id)) {
                $employee = Employee::getEmployeeByID($id);
                $_SESSION['employeeBeingModified'] = $employee;
                $data = $employee->getAsDataArray();
                showView("views/employeeCreation.php", array('personnelcategories' => $prcategoriesData) + $data);
            } else {
                redirectTo('index.php');
            }
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    redirectTo('../kirjautuminen.php');
}
