<?php

function getDatabaseConnection() {
    static $connection = null; //Muuttuja, jonka sisältö säilyy getDatabaseConnection-kutsujen välillä.

    if ($connection === null) {
        //Tämä koodi suoritetaan vain kerran
        //
        //$dsn = "host=localhost;port=1234;dbname=testdb;user=johndoe;password=mypass";
        $dsn = "";
        $connection = new PDO('pgsql:'.$dsn);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $connection;
}
