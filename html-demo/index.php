<?php

$title = 'Lääkäriaseman työvuorolistat';
require './topheader.php';
include './header.php';

$type = $_GET["type"];
switch ($type) {
    case "omat-tyovuorot" :
        include "omattyovuorot.php";
        break;
    case "tyovuorot" :
        include "tyovuorot.php";
        break;   
    case "henkvahvuuskalenteri" :
        include "henkvahvuuskalenteri.php";
        break;
    case "henkvahvuuskalenteri-muokkaa" :
        include "henkvahvuuskalenteri-muokkaa.php";
        break;
    case "kiireellisyysluokat" :
        include "kiireellisyysluokat.php";
        break;
     case "kiireellisyysluokka-muokkaa" :
        include "kiireellisyysluokka-muokkaa.php";
        break;
    case "tyontekijat" :
        include "tyontekijat.php";
        break;
    case "tyontekija" :
        include "tyontekija.php";
        break;
    case "tyontekija-muokkaa" :
        include "tyontekija-muokkaa.php";
        break;
    case "tyovuorot-muokkaa" :
        include "tyovuorot-muokkaa.php";
        break;
    default :
         include "omattyovuorot.php";
}
require './footer.php';
?>
