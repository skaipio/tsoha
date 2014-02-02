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
