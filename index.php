<?php
require_once 'libs/common.php';
if (isset($_GET["logout"])){
    unset($_SESSION["loggedIn"]);    
    showView('views/login.php');
}
if (isLoggedIn()) {
    header('Location: omattyovuorot.php');
}else{
    showView('views/login.php');
}
