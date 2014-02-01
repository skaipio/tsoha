<?php
require_once 'libs/common.php';
if (isset($_GET["logout"])){
    unset($_SESSION["loggedIn"]);
    
    header('Location: doLogin.php');
}
if (isLoggedIn()) {
    header('Location: tyontekijalista.php');
}else{
    header('Location: doLogin.php');
}
