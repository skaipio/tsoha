<?php

require '../models/personnelcategory.php';
require '../models/workshifthour.php';
require '../libs/common.php';
require '../views/shiftCalendarView.php';

class ShiftCalendarController {

    public function index() {
        setNavBarAsVisible(true);

        if (!isset($_SESSION['weekViewed'])) {
            $monday = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));
            $_SESSION['weekViewed'] = $monday;
        } else {
            $monday = $_SESSION['weekViewed'];
        }

        if (isset($_GET['day'])) {
            $dayViewed = $_GET['day'];
            $_SESSION['dayViewed'] = $dayViewed;
        }
        if (!isset($_SESSION['dayViewed'])) {
            $_SESSION['dayViewed'] = 0;
        }

        $dayViewed = $_SESSION['dayViewed'];
        $dateViewed = date('Y-m-d', strtotime($monday . '+' . ($dayViewed) . ' days'));

        $sunday = date('Y-m-d', strtotime($monday . '+' . (6) . ' days'));
        $dates = dateRange($monday, $sunday);

        $employees = Employee::getEmployeesWithShiftLimitDetails();
        $_SESSION['employees'] = $employees;
        $workshifts = Workshifthour::getAllWorkShiftsByDateRangeWithEmployeeIDsAndHours($monday, $sunday);
        $_SESSION['workshifts'] = $workshifts;
        $personnelCategories = Personnelcategory::getPersonnelCategoriesArray();

        showView('views/shiftCalendar.php', array('admin' => true, 'dayViewed' => $dayViewed, 'dateViewed' => $dateViewed,
            'dates' => $dates, 'employees' => $employees, 'workshifts' => $workshifts, 'personnelCategories' => $personnelCategories));
    }

    public function modify() {
        setNavBarAsVisible(true);

        $monday = $_SESSION['weekViewed'];

        if (isset($_GET['day'])) {
            $dayViewed = $_GET['day'];
            $_SESSION['dayViewed'] = $dayViewed;
        }
        if (!isset($_SESSION['dayViewed'])) {
            $_SESSION['dayViewed'] = 0;
        }

        $dayViewed = $_SESSION['dayViewed'];
        $dateViewed = date('Y-m-d', strtotime($monday . '+' . ($dayViewed) . ' days'));

        $sunday = date('Y-m-d', strtotime($monday . '+' . (6) . ' days'));
        $dates = dateRange($monday, $sunday);

        $employees = $_SESSION['employees'];
        $workshifts = $_SESSION['workshifts'];
        $personnelCategories = Personnelcategory::getPersonnelCategoriesArray();

        showView('views/shiftCalendar.php', array('admin' => true, 'dayViewed' => $dayViewed, 'modify' => true, 'dateViewed' => $dateViewed,
            'dates' => $dates, 'employees' => $employees, 'workshifts' => $workshifts, 'personnelCategories' => $personnelCategories));
    }

    public function submit() {
        
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
