<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
$path = $root . "/libs/common.php";
require $path;

$user = getUserLoggedIn();
if (isset($user)) { 
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = getSubmittedEmployeeData();
            $employee = Employee::createEmployeeFromData((object)$data);
            if ($employee->isValid()){
                $employee->addToDatabase();                             
                header('Location: ../tyontekijat.php');    
                $_SESSION['notification'] = "Uusi työntekijä on onnistuneesti lisätty tietokantaan.";
            }else{
                setErrors($employee->getErrors());
                showView("views/addEmployee.php", array('personnelcategories' => $prcategories) + $data);
            }           
        }
        showView('views/addEmployee.php', array('isadmin' => $admin, 'personnelcategories' => $prcategories));
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate(array('admin'=>$user->isAdmin()));
    }
} else {
    header('Location: ../kirjautuminen.php');
}

