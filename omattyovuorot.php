<?php
require 'libs/common.php';
require_once 'models/employee.php';

$user = getUserLoggedIn();

if (isset($user)) { 
    setNavBarAsVisible(true);
    showView('views/employeeWorkShifts.php', $user->getAsDataArray());
} else {
    header('Location: kirjautuminen.php');
}

