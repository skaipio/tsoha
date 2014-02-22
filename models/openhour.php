<?php

class OpenHour {

    private $errors = array();
    private $id;
    private $opendate;
    private $hour;
    private $urgencycategory_id;
    private $isInDatabase = false;

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
        $this->opendate = $openDate;
    }

    public function setHour($hour) {
        $this->hour = $hour;
    }

    public function setUrgencyCategoryID($id) {
        $this->urgencycategory_id = (int) $id;
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function addToDatabase() {
        if ($this->isInDatabase) {
            return;
        }
        $sql = "INSERT INTO openhour(opendate, hour, urgencycategory_id)"
                . "VALUES (?,?,?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $ok = $query->execute(array($this->getOpenDate(), $this->getHour(), $this->getUrgencyCategoryID()));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public static function getAllBetweenDates($startDate, $endDate) {
        $sql = "SELECT id, opendate, hour, urgencycategory_id"
                . " FROM openhour WHERE opendate >= ? AND opendate <= ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($startDate, $endDate));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $date = OpenHour::formatDBDate($result->opendate);
            $hour = OpenHour::formatDBHour($result->hour);
            if (!isset($results[$date])) {
                $results[$date] = array();
            }
            if (!isset($results[$date][$hour])) {
                $openHour = new OpenHour();
                $openHour->setID($result->id);
                $openHour->setOpenDate($date);
                $openHour->setHour($hour);
                $openHour->setUrgencyCategoryID($result->urgencycategory_id);
                $openHour->isInDatabase = true;

                $results[$date][$hour] = $openHour;
            }
        }
        return $results;
    }

    private static function formatDBDate($dbDate) {
        return date('Y-m-d', strtotime($dbDate));
    }

    private static function formatDBHour($dbHour) {
        return date('H:i', strtotime($dbHour));
    }

//    private static function formatHourToDBDate($hour){
//        return date('H:i', strtotime($hour));
//    }
}
