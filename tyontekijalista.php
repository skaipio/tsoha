<?php

require_once 'libs/common.php';

if (isLoggedIn()) {
    showView('views/employees.php');
}else{
    header('Location: kirjautuminen.php');
}



