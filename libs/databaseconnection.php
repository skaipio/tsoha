<?php
function getDatabaseConnection() {
  static $connection = null; //Muuttuja, jonka sisältö säilyy getTietokantayhteys-kutsujen välillä.

  if ($connection === null) { 
    //Tämä koodi suoritetaan vain kerran, sillä seuraavilla 
    //funktion suorituskerroilla $yhteys-muuttujassa on sisältöä.
    $connection = new PDO('pgsql:');
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  return $connection;
}
