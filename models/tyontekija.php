<?php

class Tyontekija {

    private $id;
    private $sahkoposti;
    private $salasana;
    private $osoite;

    public function __construct($id, $sahkoposti, $salasana) {
        $this->id = $id;
        $this->sahkoposti = $sahkoposti;
        $this->salasana = $salasana;
    }

    public function getSahkoposti() {
        return $this->sahkoposti;
    }

    public function getOsoite() {
        return $this->osoite;
    }

    public static function getTyontekijat() {
        $sql = "SELECT id, sahkoposti, salasana from tyontekija";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tyontekija = new Tyontekija($tulos->id, $tulos->sahkoposti, $tulos->salasana);
            $tulokset[] = $tyontekija;
        }
        return $tulokset;
    }

    public static function getTyontekijaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT id, salasana, sahkoposti FROM tyontekija WHERE salasana = ? AND sahkoposti = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($salasana, $sahkoposti));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $tyontekija = new Tyontekija($tulos->id, $tulos->sahkoposti, $tulos->salasana);
//            $tyontekija->id = $tulos->id;
//            $tyontekija->sahkoposti = $tulos->sahkoposti;
//            $tyontekija->salasana = $tulos->salasana;

            return $tyontekija;
        }
    }

}
