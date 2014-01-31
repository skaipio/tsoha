<?php
class Tyontekija{
    private $id;
    private $kayttajanimi;
    private $sahkoposti;
    private $osoite;
    
    public function __construct($id, $kayttajanimi, $sahkoposti, $osoite) {
        $this->id = $id;
        $this->kayttajanimi = $kayttajanimi;
        $this->sahkoposti = $sahkoposti;
        $this->osoite = $osoite;
    }
    
    public function getKayttajanimi(){
        return $this->kayttajanimi;
    }
    public function getSahkoposti(){
        return $this->sahkoposti;
    }
    public function getOsoite(){
        return $this->osoite;
    }

    public static function getTyontekijat() {      
        $sql = "SELECT id, kayttajanimi, sahkoposti, osoite from tyontekija";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
            $tyontekija = new Tyontekija($tulos->id, $tulos->kayttajanimi, $tulos->sahkoposti, $tulos->osoite);
            $tulokset[] = $tyontekija;
        }
        return $tulokset;
    }

}
  

