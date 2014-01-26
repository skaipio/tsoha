<?php

$title = 'Lääkäriaseman työvuorolistat';
require './topheader.php';
include './header.php';

$type = $_GET["type"];
switch ($type) {
    case "omat-tyovuorot" :
        include "omattyovuorot.php";
        break;
    case "tyovuorolistat" :
        include "tyovuorolistat.php";
        break;   
    case "henkvahvuuskalenteri" :
        include "vahvuuskalenteri.php";
        break;
    case "tyontekijat" :
        include "tyontekijat.php";
        break;
    case "muokkaa-tyontekijaa=1" :
        include "muokkaa-tyontekijaa.php";
        break;
    default :
         include "omattyovuorot.php";
}
require './footer.php';
?>
