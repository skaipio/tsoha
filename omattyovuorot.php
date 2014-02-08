<?php

$root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
$path = $root . "/libs/common.php";
require_once($path);
$path = $root . "/models/personnelcategory.php";
require_once($path);

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    showView('views/employeeworkshifthours.php', $user->getAsDataArray() + array('includeNavBar' => 1));
} else {
    header('Location: kirjautuminen.php');
}

