<?php

require '../models/openhour.php';
require '../models/urgencycategory.php';
require '../models/personnelcategory.php';

class OpenHourController {

    public function index() {
        setNavBarAsVisible(true);    
        
        if (!isset($_SESSION['weekViewed'])){
            $monday = date('Y-m-d',strtotime('last monday', strtotime('tomorrow')));
            $_SESSION['weekViewed'] = $monday;
        }else{
            $monday = $_SESSION['weekViewed'];
        }
        
        $sunday = date('Y-m-d', strtotime($monday.'+'.(6).' days'));
        
        $dates = dateRange($monday, $sunday);
        
        $openHoursOfThisWeek = OpenHour::getAllBetweenDates($monday, $sunday);
        $urgencyCategories = UrgencyCategory::getWithMinimumsAndPersonnelCategoryNames();
        $personnelCategories = Personnelcategory::getPersonnelCategories();
        
        showView('views/staffingcalendar.php', array('admin'=>true, 'personnelCategories'=>$personnelCategories,
            'openHours'=>$openHoursOfThisWeek, 'urgencyCategories'=>$urgencyCategories, 'dates'=>$dates));
    }
    
    public function previousWeek(){
        $this->redirectToIndexIfNoWeekViewed();
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfPreviousWeek($monday));
        $_SESSION['weekViewed'] = date('Y-m-d', strtotime($monday.'-'.(7).' days'));
        
        $this->index();
    }
    
    public function nextWeek(){
        $this->redirectToIndexIfNoWeekViewed();
        $monday = $this->getWeekViewed();
        $this->setWeekViewed($this->getDayOfNextWeek($monday));
        
        $this->index();
    }
    
    private function setWeekViewed($mondayOfWeek){
        $_SESSION['weekViewed'] = date('Y-m-d', $mondayOfWeek);
    }
    
    private function redirectToIndexIfNoWeekViewed(){
        if(!isset($_SESSION['weekViewed'])){
            $this->index(); 
        }
    }
    
    private function getWeekViewed(){
        return $_SESSION['weekViewed'];
    }
    
    private function getDayOfPreviousWeek($dayOfThisWeek){
        return strtotime($dayOfThisWeek.'-'.(7).' days');
    }
    
    private function getDayOfNextWeek($dayOfThisWeek){
        return strtotime($dayOfThisWeek.'+'.(7).' days');
    }
}
