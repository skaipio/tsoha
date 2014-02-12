<?php

require '../libs/common.php';
require '../models/urgencycategory.php';
require '../models/minimumpersonnel.php';

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(true);
    $admin = $user->isAdmin();
    if ($admin) {
        $ucategories = UrgencyCategory::getUrgencyCategories();
        $personnelcategories = Personnelcategory::getPersonnelCategories();
        $personnelcategoryNames = getPersonnelCategoriesDataArray();
        $ucategoriesData = array();
        foreach ($ucategories as $ucategory) {
            $minimumpersonnels = array();
            $ucategoryData = $ucategory->getAsDataArray();
            foreach ($personnelcategories as $pcategory) {
                $minimumpersonnel = MinimumPersonnel::getMinimumPersonnelByUrgencyCategoryAndPersonnelCategory($ucategory->getID(), $pcategory->getID());
                $minimumpersonnels[] = (object) array('name' => $pcategory->getName(), 'minimum' => $minimumpersonnel->getMinimum());
            }
            $ucategoryData['minimumpersonnels'] = $minimumpersonnels;
            $ucategoriesData[] = (object) $ucategoryData;
        }
        showView('views/urgencyCategoriesListing.php', array('admin' => $admin,
            'urgencycategories' => $ucategoriesData, 'personnelcategories' => $personnelcategoryNames));
    } else {
        $errors = array("Sivu vaatii ylläpito-oikeudet.");
        setErrors($errors);
        showOnlyTemplate(array('admin' => $admin));
    }
} else {
    redirectTo('../kirjautuminen.php');
}





