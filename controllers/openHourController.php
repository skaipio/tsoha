<?php

require '../models/openhour.php';
require '../libs/common.php';
require '../models/urgencycategory.php';
require '../models/personnelcategory.php';
require '../views/staffingCalendarView.php';

class OpenHourController {

    public function index() {
        setNavBarAsVisible(true);

        unset($_SESSION['openHours']);

        if (!isset($_SESSION['weekViewed'])) {
            $monday = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));
            $_SESSION['weekViewed'] = $monday;
        } else {
            $monday = $_SESSION['weekViewed'];
        }

        $sunday = date('Y-m-d', strtotime($monday . '+' . (6) . ' days'));

        $dates = dateRange($monday, $sunday);

        $openHoursOfThisWeek = OpenHour::getAllBetweenDates($monday, $sunday);
        $urgencyCategories = UrgencyCategory::getWithMinimumsAndPersonnelCategoryNames();
        $personnelCategories = Personnelcategory::getPersonnelCategories();

        showView('views/staffingcalendar.php', array('admin' => true, 'personnelCategories' => $personnelCategories,
            'openHours' => $openHoursOfThisWeek, 'urgencyCategories' => $urgencyCategories, 'dates' => $dates));
    }

    public function modify() {
        if (!isset($_SESSION['weekViewed'])) {
            redirectTo('index.php');
        } else {
            $monday = $_SESSION['weekViewed'];
        }

        $sunday = date('Y-m-d', strtotime($monday . '+' . (6) . ' days'));
        $dates = dateRange($monday, $sunday);

        if (!isset($_SESSION['openHours'])) {
            $_SESSION['openHours'] = OpenHour::getAllBetweenDates($monday, $sunday);
        }

        $openHoursOfThisWeek = $_SESSION['openHours'];

        if (isset($_GET["ucid"]) && isset($_GET["date"]) && isset($_GET["hour"])) {
            $date = $_GET["date"];
            $hour = $_GET["hour"];
            $openHour = new OpenHour();
            $openHour->setOpenDate($date);
            $openHour->setHour($hour);
            $openHour->setUrgencyCategoryID($_GET["ucid"]);
            if (!isset($openHoursOfThisWeek[$date])) {
                $openHoursOfThisWeek[$date] = array();
            }
            $openHoursOfThisWeek[$date][$hour] = $openHour;
            $_SESSION['openHours'] = $openHoursOfThisWeek;
        }

        $urgencyCategories = UrgencyCategory::getWithMinimumsAndPersonnelCategoryNames();
        $personnelCategories = Personnelcategory::getPersonnelCategories();

        showView('views/staffingcalendar.php', array('admin' => true, 'modify' => true, 'personnelCategories' => $personnelCategories,
            'openHours' => $openHoursOfThisWeek, 'urgencyCategories' => $urgencyCategories, 'dates' => $dates));
    }

    public function submit() {
        $openHours = $_SESSION['openHours'];

        foreach ($openHours as $date => $openHoursOfDate) {
            foreach ($openHoursOfDate as $hour => $openHour) {
                if ($openHour->isValid()){
                    $openHour->addToDatabase();
                }
            }
        }
        
        setSuccesses(array('Aukioloajat on tallennettu tietokantaan.'));
    }

    public function previousWeek() {
        $this->redirectToIndexIfNoWeekViewed();
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfPreviousWeek($monday));
        $_SESSION['weekViewed'] = date('Y-m-d', strtotime($monday . '-' . (7) . ' days'));

        $this->index();
    }

    public function nextWeek() {
        $this->redirectToIndexIfNoWeekViewed();
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfNextWeek($monday));

        $this->index();
    }

    private function setWeekViewed($mondayOfWeek) {
        $_SESSION['weekViewed'] = date('Y-m-d', $mondayOfWeek);
    }

    private function redirectToIndexIfNoWeekViewed() {
        if (!isset($_SESSION['weekViewed'])) {
            $this->index();
        }
    }

    private function getWeekViewed() {
        return $_SESSION['weekViewed'];
    }

    private function getDayOfPreviousWeek($dayOfThisWeek) {
        return strtotime($dayOfThisWeek . '-' . (7) . ' days');
    }

    private function getDayOfNextWeek($dayOfThisWeek) {
        return strtotime($dayOfThisWeek . '+' . (7) . ' days');
    }

}
