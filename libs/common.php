<?php

require_once 'libs/databaseconnection.php';
require_once 'models/employee.php';

session_start();

function showView($page, $data = array()) {
    $data = (object) $data;
    require_once 'views/header.php';
    require_once $page;
    require_once 'views/footer.php';
    exit();
}

function postParametersExist($parameters = array()) {
    foreach ($parameters as $param) {
        if (empty($_POST[$param])) {
            return false;
        }
    }
    return true;
}

function attemptLogin($email, $password) {
    $user = Employee::getEmployeeByLoginInfo($email, $password);
    return $user;
}

function isLoggedIn() {
    return isset($_SESSION['loggedIn']);
}

function getUserLoggedIn() {
    $user = $_SESSION['loggedIn'];
    return $user;
}

function getEmployeeDetailsObject($employee) {
    $personnelcategory = Personnelcategory::getPersonnelCategoryById($employee->getPersonnelCategoryID());
    return (object) array(
                'firstname' => $employee->getFirstName(),
                'lastname' => $employee->getLastName(),
                'personnelcategory' => $personnelcategory->getName()
    );
}

function getPersonnelCategoriesAsDataArray(){  
    $pcategories = Personnelcategory::getPersonnelCategories();
    $pcategoriesData = array();
    foreach ($pcategories as $pcategory){
        $pcategoriesData[]= (object)array('id'=>$pcategory->getID(), 'name'=>$pcategory->getName());
    }
    return $pcategoriesData;
}

function trimInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function getSubmittedEmployeeData() {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $ssn = $_POST['ssn'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $admin = $_POST['admin'];
    $pcategory = $_POST['personnelcategory'];
    $maxhoursperweek = $_POST['maxhoursperweek'];
    $maxhoursperday = $_POST['maxhoursperday'];
    $data = array('firstname' => $firstname, 'lastname' => $lastname, 'ssn' => $ssn,
        'address' => $address, 'email' => $email, 'phone' => $phone, 'admin' => $admin,
        'personnelcategory'=>$pcategory, 'maxhoursperweek' => $maxhoursperweek, 'maxhoursperday' => $maxhoursperday);
    return $data;
}
