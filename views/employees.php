<?php

$tyontekijat = Tyontekija::getTyontekijat();

foreach ($tyontekijat as $tyontekija) {
    echo $tyontekija->getEmail();
}

