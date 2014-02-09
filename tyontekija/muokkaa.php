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
            $employee->setFromData($data);
            if ($employee->isValid()){
                $employee->updateDatabaseEntry();  
                unset($_SESSION['employeeBeingModified']);
                $id = $employee->getID();
                header("Location: nayta.php?id=$id");    
                setSuccesses(array("Työntekijää on onnistuneesti muokattu."));
            }else{
                setErrors($employee->getErrors());
                showView("views/modifyEmployee.php", array('personnelcategories' => $prcategories) + $data);
            }           
        }
        
        $employee = $_SESSION['employeeBeingModified'];
        $prcategoriesData = getPersonnelCategoriesDataArray();
        if (isset($employee)){
            $employee = $employee->getAsDataArray();
            showView("views/modifyEmployee.php", array('personnelcategories' => $prcategoriesData) + $employee);
        }
        $id = $_GET['id'];
        if (isset($id)) {           
            $employee = Employee::getEmployeeByID($id);
            $_SESSION['employeeBeingModified'] = $employee;          
            $employee = $employee->getAsDataArray();
            showView("views/modifyEmployee.php", array('personnelcategories' => $prcategoriesData) + $employee);
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    header('Location: ../kirjautuminen.php');
}

