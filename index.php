<?php
if (isset($_GET["destroySession"])) {
    session_unset();
}

require_once 'libs/common.php';

if (isLoggedIn()) {
    header('Location: tyontekijalista.php');
}else{
    header('Location: doLogin.php');
}
