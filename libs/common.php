<?php
session_start();

require_once 'libs/tietokantayhteys.php';
require_once 'models/tyontekija.php';

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
    $user = Tyontekija::getTyontekijaTunnuksilla($email, $password);

    return $user;
}

function isLoggedIn() {
    if (isset($_SESSION['loggedIn'])) {
        $user = $_SESSION['loggedIn'];
        return true;
        //return (isset($user->email) && isset($user->password));
    }
    else{
        return false;
    }
}
