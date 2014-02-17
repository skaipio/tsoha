<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
$path = $root . "/libs/databaseconnection.php";
require($path);
$path = $root . "/models/employee.php";
require($path);

session_start();

function showView($page, $data = array()) {
    $root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
    $data = (object) $data;
    require_once($root . '/views/header.php');
    require_once ($root . '/' . $page);
    require_once($root . '/views/footer.php');
    exit();
}

function showOnlyTemplate($data = array()) {
    $root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
    include($root . '/views/header.php');
    include($root . '/views/footer.php');
    exit();
}

function redirectTo($location) {
    header('Location: ' . $location);
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

function getUserLoggedIn() {
    return $_SESSION['loggedIn'];
}

function loggedInAsAdmin(){
    $user = $_SESSION['loggedIn'];
    if (isset($user)){
        if ($user->isAdmin()){
            return true;
        }else{
            setErrors(array('Sivu vaatii ylläpito-oikeudet.'));
            redirect('kirjautuminen.php');
        }
    }
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
    $admin = isset($_POST['admin']) ? $_POST['admin'] : false;
    $pcategory = $_POST['personnelcategory_id'];
    $maxhoursperweek = $_POST['maxhoursperweek'];
    $maxhoursperday = $_POST['maxhoursperday'];
    $data = array('firstname' => $firstname, 'lastname' => $lastname, 'ssn' => $ssn,
        'address' => $address, 'email' => $email, 'phone' => $phone, 'admin' => $admin,
        'personnelcategory_id' => $pcategory, 'maxhoursperweek' => $maxhoursperweek, 'maxhoursperday' => $maxhoursperday);
    return $data;
}



function isActivePage($page) {
    $current = filter_input(INPUT_SERVER, 'PHP_SELF');
    return $current === $page;
}

function setNavBarAsVisible($visible) {
    $_SESSION['navBarVisible'] = $visible;
}

function echoToPage($property) {
    echo htmlspecialchars($property);
}

function echoNotifications($notifications) {
    foreach ($notifications as $notification) {
        echo $notification;
    }
}

function setSuccesses($successes) {
    $_SESSION['successes'] = $successes;
}

function setWarnings($warnings) {
    $_SESSION['warnings'] = $warnings;
}

function setErrors($errors) {
    $_SESSION['errors'] = $errors;
}
