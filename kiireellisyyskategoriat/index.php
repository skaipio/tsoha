<?php

require '../libs/common.php';
require '../controllers/urgencyCategoryController.php';
require '../models/minimumpersonnel.php';


if (loggedInAsAdmin()) {
    setNavBarAsVisible(true);
    
    $controller = new UrgencyCategoryController();
    
    $urgencyCategories = $controller->getUrgencyCategoryList();
    $personnelCategories = Personnelcategory::getPersonnelCategories();
    
    showView('views/urgencyCategoryListing.php', array('admin' => true,
            'personnelCategories' => $personnelCategories, 'urgencyCategories' => $urgencyCategories));
}






