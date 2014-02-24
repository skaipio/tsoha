<?php
require_once 'libs/common.php';

if (isset($_GET["logout"])){
    unset($_SESSION["loggedIn"]);   
    header('Location: kirjautuminen.php');
}
$user = getUserLoggedIn();
if (isset($user)) {
    header('Location: tyovuorot/tyontekija.php');
}else{
    header('Location: kirjautuminen.php');
}
