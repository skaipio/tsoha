<?php

//$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
//$path = $root . "/libs/common.php";
//require_once($path);
//$path = $root . "/models/personnelcategory.php";
//require_once($path);

require 'libs/common.php';
require_once 'models/employee.php';

$user = getUserLoggedIn();

if (isset($user)) { 
    setNavBarAsVisible(true);
    showView('views/employeeWorkShifts.php', $user->getAsDataArray());
} else {
    header('Location: kirjautuminen.php');
}

