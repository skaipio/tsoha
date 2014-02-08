<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
$path = $root . "/libs/common.php";
require_once($path);
$path = $root . "/models/employee.php";
require_once($path);

if (isLoggedIn()) {
    $user = getUserLoggedIn();
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
                $_SESSION['notification'] = "Työntekijää on onnistuneesti muokattu.";
            }else{
                showView("views/modifyEmployee.php", array('personnelcategories' => $prcategories, 'errors'=>$employee->getErrors()) + $data);
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
        echo "Sivu vaatii ylläpito-oikeudet.";
    }
} else {
    header('Location: kirjautuminen.php');
}

