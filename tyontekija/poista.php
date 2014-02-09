<?php

require '../libs/common.php';

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $id = $_GET['id'];
        if (isset($id)) {
            Employee::removeEmployeeFromDatabase($id);
            setSuccesses(array('Tyontekijä on poistettu tietokannasta.'));
            header('Location: ../tyontekijat.php');
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    header('Location: ../kirjautuminen.php');
}