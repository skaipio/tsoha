<?php

class Workshifthour {

    private $id;
    private $openhour;
    private $openhour_id;
    private $employee_id;

    public function __construct($id, $openhour, $employee_id) {
        $this->id = $id;
        $this->openhour = $openhour;
        $this->employee_id = $employee_id;
    }
    
    public function setOpenHourID($id){
        $this->openhour_id = (int)$id;
    }
    
    public function addToDatabase() {
        $sql = "INSERT INTO workshifthour(openhour_id, employee_id)"
                . "VALUES (?,?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $ok = $query->execute(array($this->openhour_id, $this->employee_id));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }
    
    public function removeFromDatabase() {
        if (!isset($this->id)) {
            return;
        }
        $sql = "DELETE FROM workshifthour WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($this->id));
    }

    public static function getAllWorkshifthoursForEmployee($id) {
        $sql = "SELECT id, openhour_id FROM workshifthour WHERE employee_id = ?";
        $query = getDatabaseConnection()->prepare($sql);
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

    public static function getAllOpenhourIDsForEmployee($id) {
        $sql = "SELECT openhour_id FROM workshifthour WHERE employee_id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = $result->openhour_id;
        }
        return $results;
    }

    public static function getAllWorkShiftsByDateRangeWithEmployeeIDsAndHours($startDate, $endDate) {
        $sql = "SELECT workshifthour.id as wsid, openhour.opendate, openhour.hour, employee_id"
                . " FROM workshifthour, openhour WHERE"
                . " openhour_id = openhour.id AND"
                . " openhour.opendate >= ? AND openhour.opendate <= ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($startDate,$endDate));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            if (!isset($results[$result->employee_id])) {
                $results[$result->employee_id] = array();
            }
            
            $date = date('Y-m-d', strtotime($result->opendate));
            
            if (!isset($results[$result->employee_id][$date])) {              
                $results[$result->employee_id][$date] = array();
            }
            $hour = date('H:i', strtotime($result->hour));
            $results[$result->employee_id][$date][$hour] = new Workshifthour(
                    $result->wsid, $hour, $result->employee_id);
        }
        return $results;
    }

}
