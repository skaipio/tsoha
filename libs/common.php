<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
$path = $root . "/libs/databaseconnection.php";
require_once($path);
$path = $root . "/models/employee.php";
require_once($path);

//        $path = realpath(dirname(__FILE__)) . "/";
//        include_once $path . "/common/header.php";


session_start();

function showView($page, $data = array()) {
    $root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
    $data = (object) $data;
    require_once($root . '/views/header.php');
    require_once ($root . '/' . $page);
    require_once($root . '/views/footer.php');
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

function requireFiles($files = array()){
    $root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
    foreach($files as $file){
        require_once($root . $file);
    }
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

function getPersonnelCategoriesDataArray() {
    $pcategories = Personnelcategory::getPersonnelCategories();
    $pcategoriesData = array();
    foreach ($pcategories as $pcategory) {
        $pcategoriesData[] = (object)$pcategory->getAsDataArray();
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
    $pcategory = $_POST['personnelcategory_id'];
    $maxhoursperweek = $_POST['maxhoursperweek'];
    $maxhoursperday = $_POST['maxhoursperday'];
    $data = array('firstname' => $firstname, 'lastname' => $lastname, 'ssn' => $ssn,
        'address' => $address, 'email' => $email, 'phone' => $phone, 'admin' => $admin,
        'personnelcategory_id' => $pcategory, 'maxhoursperweek' => $maxhoursperweek, 'maxhoursperday' => $maxhoursperday);
    return $data;
}
