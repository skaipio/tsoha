<?php

class Workshifthour {

    private $id;
    private $openhour_id;
    private $employee_id;    

    public function __construct($id, $openhour_id, $employee_id) {
        $this->id = $id;
        $this->openhour_id = $openhour_id;
        $this->employee_id = $employee_id;      
    }
    
    public static function getAllWorkshifthoursForEmployee($id){
        $sql = "SELECT id, openhour_id FROM workshifthour WHERE employee_id = ?";
        $query = getTietokantayhteys()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $workshifthour = new Workshifthour();
            $workshifthour->id = $result->id;
            $workshifthour->openhour_id = $result->openhour_id;
            $results[] = $workshifthour;
        }
        return $results;
    }
    
    public static function getAllOpenhourIDsForEmployee($id){
        $sql = "SELECT openhour_id FROM workshifthour WHERE employee_id = ?";
        $query = getTietokantayhteys()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = $result->openhour_id;
        }
        return $results;
    }
}

