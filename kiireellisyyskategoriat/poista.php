<?php
require '../libs/common.php';
require "../models/urgencycategory.php";

$user = getUserLoggedIn();
if (isset($user)) {
    $admin = $user->isAdmin();
    if ($admin) {
        $id = $_GET['id'];
        if (isset($id)) {
            if (UrgencyCategory::removeFromDatabase($id)){
                setSuccesses(array('Kiireellisyyskategoria on poistettu tietokannasta.'));
            }else{
                setErrors(array('Kiireellisyyskategoriaa ei voitu poistaa tietokannasta.'));
            }
            redirectTo('index.php');
        }
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate();
    }
} else {
    redirectTo('../kirjautuminen.php');
}