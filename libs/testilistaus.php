<?php
require_once 'tietokantayhteys.php';
require_once '../models/tyontekija.php';
//Lista asioista array-tietotyyppiin laitettuna:
$tyontekijat = Employee::getEmployees();
?>
<!DOCTYPE HTML>
<html>
    <head><title>Otsikko</title></head>
    <body>
        <h1>Listaelementtitesti</h1>
        <ul>
            <?php foreach ($tyontekijat as $tyontekija): ?>
            <li><?php
            $kayttajanimi = $tyontekija->getKayttajanimi();
            $sposti = $tyontekija->getEmail();
            $osoite = $tyontekija->getOsoite();
            echo "$kayttajanimi, $sposti, $osoite"?>
            </li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>
