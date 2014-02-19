<?php

require '../models/openhour.php';
require '../models/urgencycategory.php';

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
        $urgencyCategories = UrgencyCategory::getUrgencyCategoriesArray();
        
        showView('views/staffingcalendar.php', array('admin'=>true,
            'openHours'=>$openHoursOfThisWeek, 'urgencyCategories'=>$urgencyCategories, 'dates'=>$dates));
    }
    
    public function previousWeek(){
        if(!isset($_SESSION['weekViewed'])){
            $this->index(); 
        }
        $monday = $_SESSION['weekViewed'];
        $_SESSION['weekViewed'] = date('Y-m-d', strtotime($monday.'-'.(7).' days'));
        
        $this->index();
    }
    
    public function nextWeek(){
        if(!isset($_SESSION['weekViewed'])){
            $this->index(); 
        }
        $monday = $_SESSION['weekViewed'];
        $_SESSION['weekViewed'] = date('Y-m-d', strtotime($monday.'+'.(7).' days'));
        
        $this->index();
    }
}
