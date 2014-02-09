<?php
require_once 'libs/common.php';

//Tarkistetaan että vaaditut kentät on täytetty:

setNavBarAsVisible(false);

if (!postParametersExist(array('email'))) {
    showView("views/login.php", array(
        'error' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}
$email = $_POST["email"];

if (!postParametersExist(array('salasana'))) {
    showView("views/login.php", array(
        'email' => $email,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}
$password = $_POST["salasana"];

$user = Employee::getEmployeeByLoginInfo($email, $password);

if (isset($user)) {
    $_SESSION['loggedIn'] = $user;
    header('Location: omattyovuorot.php');
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showView("views/login.php",array(
        'email' => $email,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}