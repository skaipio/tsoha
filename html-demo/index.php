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
    case "tyontekijat" :
        include "tyontekijat.php";
        break;
    case "muokkaa-tyontekijaa=1" :
        include "muokkaa-tyontekijaa.php";
        break;
    case "tyovuorot-muokkaa" :
        include "tyovuorot-muokkaa.php";
        break;
    default :
         include "omattyovuorot.php";
}
require './footer.php';
?>
