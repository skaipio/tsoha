<?php
require_once 'libs/tietokantayhteys.php';
require_once 'models/tyontekija.php';
//use Tyontekija;

$tyontekijat = Tyontekija::getTyontekijat();

foreach($tyontekijat as $tyontekija){
    echo $tyontekija->getSahkoposti();
}

