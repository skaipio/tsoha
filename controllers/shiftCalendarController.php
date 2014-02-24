<?php

require '../models/personnelcategory.php';
require '../models/workshifthour.php';
require '../models/openhour.php';
require '../models/urgencycategory.php';
require '../libs/common.php';
require '../views/shiftCalendarView.php';

class ShiftCalendarController {

    public function index() {
        setNavBarAsVisible(true);

        unset($_SESSION['requiredPersonnel']);
        unset($_SESSION['workShiftsToBeAdded']);
        unset($_SESSION['workShiftsToBeRemoved']);

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
        $openHoursOfThisWeek = OpenHour::getAllBetweenDates($monday, $sunday);
        $_SESSION['openHours'] = $openHoursOfThisWeek;
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

        $this->getAndSetToSessionWorkshiftsToBeRemoved();
        $this->getAndSetToSessionWorkshiftsToBeAdded();

        $dayViewed = $_SESSION['dayViewed'];
        $dateViewed = date('Y-m-d', strtotime($monday . '+' . ($dayViewed) . ' days'));

        $sunday = date('Y-m-d', strtotime($monday . '+' . (6) . ' days'));
        $dates = dateRange($monday, $sunday);

        $employees = $_SESSION['employees'];
        $workshifts = $_SESSION['workshifts'];
        $openHoursOfThisWeek = $_SESSION['openHours'];

        $personnelCategories = Personnelcategory::getPersonnelCategoriesArray();
        $urgencyCategories = UrgencyCategory::getWithMinimumsAndPersonnelCategoryNames();

        $requiredPersonnel = $this->getRequiredPersonnel($openHoursOfThisWeek, $urgencyCategories, $employees, $workshifts);
        $_SESSION['requiredPersonnel'] = $requiredPersonnel;

        showView('views/shiftCalendar.php', array('admin' => true, 'dayViewed' => $dayViewed, 'modify' => true, 'dateViewed' => $dateViewed,
            'dates' => $dates, 'employees' => $employees, 'workshifts' => $workshifts, 'personnelCategories' => $personnelCategories,
            'openHours' => $openHoursOfThisWeek, 'urgencyCategories' => $urgencyCategories, 'requiredPersonnel' => $requiredPersonnel));
    }

    public function submit() {
        if ($this->requiredPersonnelFulfilled()) {
            if (isset($_SESSION['workShiftsToBeAdded'])) {
                $workshiftsToAdd = $_SESSION['workShiftsToBeAdded'];
                foreach ($workshiftsToAdd as $workshift) {
                    $workshift->addToDatabase();
                }
            }
            if (isset($_SESSION['workShiftsToBeRemoved'])) {
                $workshiftsToRemove = $_SESSION['workShiftsToBeRemoved'];
                foreach ($workshiftsToRemove as $workshift) {
                    $workshift->removeFromDatabase();
                }
            }

            unset($_SESSION['workShiftsToBeAdded']);
            unset($_SESSION['workShiftsToBeRemoved']);
            unset($_SESSION['workshifts']);

            setSuccesses(array('Työvuoroja on onnistuneesti muokattu.'));
            redirectTo('index.php');
        } else {
            setErrors(array('Viikolla on avoimia tunteja, joille ei ole tarpeeksi työntekijöitä.'));
            redirectTo('muokkaa.php');
        }
    }

    public function employeeShifts() {
        setNavBarAsVisible(true);
        
        $user = $_SESSION['loggedIn'];

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

        $workshifts = Workshifthour::getAllWorkShiftsByDateRangeAndEmployeeIDWithHours($user->getID(), $monday, $sunday);

        showView('views/employeeWorkShifts.php', array('admin' => $user->isAdmin(), 'dayViewed' => $dayViewed, 'dateViewed' => $dateViewed,
            'dates' => $dates, 'employee' => $user, 'workshifts' => $workshifts));
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
    
    public function employeePreviousWeek() {
        if (!isset($_SESSION['weekViewed'])) {
            $this->employeeShifts();
        }
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfPreviousWeek($monday));
        $_SESSION['weekViewed'] = date('Y-m-d', strtotime($monday . '-' . (7) . ' days'));

        $this->employeeShifts();
    }

    public function employeeNextWeek() {
        if (!isset($_SESSION['weekViewed'])) {
            $this->employeeShifts();
        }
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfNextWeek($monday));

        $this->employeeShifts();
    }

    private function getRequiredPersonnel($openHoursOfThisWeek, $urgencyCategories, $employees, $workshifts) {
        $requiredPersonnel = array();
        foreach ($openHoursOfThisWeek as $date => $hours) {
            $requiredPersonnel[$date] = array();
            foreach ($hours as $hour) {
                $urgencyCategory = $urgencyCategories[$hour->getUrgencyCategoryID()];
                $minimumPersonnels = $urgencyCategory->getMinimumPersonnels();
                $requiredPersonnel[$date][$hour->getHour()] = $minimumPersonnels;
                foreach ($workshifts as $employeeID => $workshiftDates) {
                    $employee = $employees[$employeeID];
                    if (isset($workshiftDates[$date][$hour->getHour()])) {
                        $minimum = $requiredPersonnel[$date][$hour->getHour()][$employee->getPersonnelCategoryID()];
                        if ($minimum > 0) {
                            $requiredPersonnel[$date][$hour->getHour()][$employee->getPersonnelCategoryID()] --;
                        }
                    }
                }
            }
        }
        return $requiredPersonnel;
    }

    private function requiredPersonnelFulfilled() {
        $requiredPersonnel = $_SESSION['requiredPersonnel'];
        foreach ($requiredPersonnel as $date => $hours) {
            foreach ($hours as $hour) {
                foreach ($hour as $pcid => $minimum) {
                    if ($minimum > 0) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    private function getAndSetToSessionWorkshiftsToBeRemoved() {
        if (isset($_GET['poista']) && isset($_GET['date']) && isset($_GET['hour']) && isset($_GET['employeeID'])) {
            if (!isset($_SESSION['workShiftsToBeRemoved'])) {
                $_SESSION['workShiftsToBeRemoved'] = array();
            }
            $workShift = $_SESSION['workshifts'][$_GET['employeeID']][$_GET['date']][$_GET['hour']];
            $_SESSION['workShiftsToBeRemoved'][] = $workShift;
            unset($_SESSION['workshifts'][$_GET['employeeID']][$_GET['date']][$_GET['hour']]);
        }
    }

    private function getAndSetToSessionWorkshiftsToBeAdded() {
        if (isset($_GET['lisaa']) && isset($_GET['date']) && isset($_GET['hour']) && isset($_GET['employeeID'])) {
            $openHour = $_SESSION['openHours'][$_GET['date']][$_GET['hour']];
            $workShift = new Workshifthour(0, $_GET['hour'], $_GET['employeeID']);
            $workShift->setOpenHourID($openHour->getID());
            $_SESSION['workShiftsToBeAdded'][] = $workShift;
            $_SESSION['workshifts'][$_GET['employeeID']][$_GET['date']][$_GET['hour']] = $workShift;
        }
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
