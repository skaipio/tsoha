<?php

class OpenHour {

    private $errors = array();
    private $id;
    private $opendate;
    private $hour;
    private $urgencycategory_id;

    public function getErrors() {
        return $this->errors;
    }

    public function getID() {
        return $this->id;
    }

    public function getOpenDate() {
        return $this->opendate;
    }

    public function getHour() {
        return $this->hour;
    }

    public function getUrgencyCategoryID() {
        return $this->urgencycategory_id;
    }

    private function setID($id) {
        $this->id = (int) $id;
    }

    public function setOpenDate($openDate) {
        $this->opendate = date('Y-m-d', strtotime($openDate));
    }

    public function setHour($hour) {
        $this->hour = date('H:i', strtotime($hour));
    }

    public function setUrgencyCategoryID($id) {
        $this->urgencycategory_id = (int) $id;
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function addToDatabase() {
        $sql = "INSERT INTO openhour(opendate, hour, urgencycategory_id)"
                . "VALUES (?,?,?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $ok = $query->execute(array($this->getOpenDate(),
            $this->getHour(), $this->getUrgencyCategoryID()));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public function updateDatabaseEntry() {
        $sql = "UPDATE openhour SET opendate=?, hour=?, urgencycategroy_id=? WHERE id=?";
        $query = getDatabaseConnection()->prepare($sql);
        return $query->execute(array($this->getOpenDate(), $this->getHour(), $this->getUrgencyCategoryID()));
    }

    public function setFromData($data) {
        $this->setID($data->id);
        $this->setOpenDate($data->opendate);
        $this->setHour($data->hour);
        $this->setUrgencyCategoryID($data->urgencycategory_id);
    }

    public static function getAllBetweenDates($startDate, $endDate) {
        $sql = "SELECT * from openhour WHERE opendate >= ? AND opendate <= ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($startDate, $endDate));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $openHour = new OpenHour();
            $openHour->setFromData($result);
            $results[] = $openHour;
        }
        return OpenHour::splitByDatesAndHours($results);
    }
    
    private static function splitByDatesAndHours($openhours){
        $byDates = OpenHour::splitByDates($openhours);
        $byDatesAndHours = array();
        
        foreach($byDates as $date=>$hours){
            $byHours = OpenHour::splitByHours($hours);
            $byDatesAndHours[$date] = $byHours;
        }
        
        return $byDatesAndHours;
    }

    private static function splitByDates($openhours) {
        $result = array();

        foreach ($openhours as $openhour) {
            $date = $openhour->getOpenDate();
            if (!array_key_exists($date, $result)) {
                $result[$date] = array();
            }
            $result[$date][] = $openhour;
        }
        
        return $result;
    }
    
    private static function splitByHours($openhours){
        $result = array();

        foreach ($openhours as $openhour) {
            $time = $openhour->getHour();
            if (!array_key_exists($time, $result)) {
                $result[$time] = array();
            }
            $result[$time] = $openhour;
        }
        
        return $result;
    }
}
