<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require 'models/tyontekija.php';

//Tarkistetaan että vaaditut kentät on täytetty:
if (!postParamsExist(array('sahkoposti'))) {
    showView("views/login.php", array(
        'error' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",
    ));
}
$sahkoposti = $_POST["sahkoposti"];

if (!postParamsExist(array('salasana'))) {
    showView("views/login.php", array(
        'sahkoposti' => $sahkoposti,
        'error' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",
    ));
}
$salasana = $_POST["salasana"];


$tyontekija = Tyontekija::getTyontekijaTunnuksilla($sahkoposti, $salasana);

/* Tarkistetaan onko parametrina saatu oikeat tunnukset */
if (isset($tyontekija)) {
    /* Jos tunnus on oikea, ohjataan käyttäjä sopivalla HTTP-otsakkeella kissalistaan. */
    header('Location: tyontekijalista.php');
} else {
    /* Väärän tunnuksen syöttänyt saa eteensä kirjautumislomakkeen. */
    showView("views/login.php", array(
        'sahkoposti' => $sahkoposti,
        'error' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."));
}