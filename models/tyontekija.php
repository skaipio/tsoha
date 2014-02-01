<?php

class Tyontekija {

    private $id;
    private $password;
    private $email;    
    private $osoite;

    public function __construct($id, $password, $email) {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;      
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }

    public function getOsoite() {
        return $this->osoite;
    }

    public static function getTyontekijat() {
        $sql = "SELECT id, salasana, sahkoposti from tyontekija";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tyontekija = new Tyontekija($tulos->id, $tulos->salasana, $tulos->sahkoposti);
            $tulokset[] = $tyontekija;
        }
        return $tulokset;
    }

    public static function getTyontekijaTunnuksilla($email, $password) {
        $sql = "SELECT id, salasana, sahkoposti FROM tyontekija WHERE salasana = ? AND sahkoposti = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($password, $email));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $tyontekija = new Tyontekija($tulos->id, $tulos->salasana, $tulos->sahkoposti);
//            $tyontekija->id = $tulos->id;
//            $tyontekija->sahkoposti = $tulos->sahkoposti;
//            $tyontekija->salasana = $tulos->salasana;

            return $tyontekija;
        }
    }

}
