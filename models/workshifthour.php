<?php

class Workshifthour {

    private $id;
    private $openhour;
    private $employee_id;

    public function __construct($id, $openhour, $employee_id) {
        $this->id = $id;
        $this->openhour = $openhour;
        $this->employee_id = $employee_id;
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

    public static function getAllWorkShiftsByDateWithEmployeeIDsAndHours($date) {
        $sql = "SELECT workshifthour.id as wsid, openhour.hour, employee_id"
                . " FROM workshifthour, openhour WHERE"
                . " openhour_id = openhour.id AND"
                . " openhour.opendate = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($date));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            if (!isset($results[$result->employee_id])) {
                $results[$result->employee_id] = array();
            }
            $hour = date('H:i', strtotime($result->hour));
            $results[$result->employee_id][$hour] = new Workshifthour(
                    $result->wsid, $hour, $result->employee_id);
        }
        return $results;
    }

}
