<?php

require_once 'libs/common.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    if ($admin) {
        showView('views/employees.php', array('isadmin'=>$admin));    
    }
    else {
        echo "Sivu vaatii ylläpito-oikeudet.";
        //header('Location: omattyovuorot.php');
    }
} else {
    header('Location: kirjautuminen.php');
}



