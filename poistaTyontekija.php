<?php
require_once 'libs/common.php';

if (isLoggedIn()) {
    $user = getUserLoggedIn();
    $admin = $user->isAdmin();
    if ($admin) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
            $id = $_POST['id'];
            if (isset($id) && isset($_POST['delete'])){ 
                Employee::removeEmployeeFromDatabase($id);
                header('Location: tyontekijat.php');    
            }      
        }
    } else {
        echo "Sivu vaatii ylläpito-oikeudet.";
    }
} else {
    header('Location: kirjautuminen.php');
}