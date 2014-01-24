<?php

$title = 'Lääkäriaseman työvuorolistat';
require './topheader.php';
include './header.php';

$type = $_GET["type"];
switch ($type) {
    case "tyovuorot" :
        include "tyovuorot.php";
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
    default :
         include "tyovuorot.php";
}
require './footer.php';
?>
