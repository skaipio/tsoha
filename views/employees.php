<?php
require_once 'topnavbar.php';
$tyontekijat = Tyontekija::getTyontekijat();

foreach ($tyontekijat as $tyontekija) {
    echo $tyontekija->getEmail();
}

