<?php

require "../libs/common.php";
require "../models/urgencycategory.php";
require "../models/minimumpersonnel.php";

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ucdata = getSubmittedUrgencyCategoryData();
            $minimpDatas = (object) getSubmittedMinimumPersonnelData();
            $urgencycategory = UrgencyCategory::createFromData($ucdata);
            if ($urgencycategory->addToDatabase()) {
                foreach ($minimpDatas as $pcid => $minimum) {
                    $minimp = MinimumPersonnel::createFromData(array('urgencycategory_id' => $urgencycategory->getID(),
                                'personnelcategory_id' => $pcid, 'minimum' => $minimum));
                    $minimp->addToDatabase();
                }
            }
            setSuccesses(array("Uusi kiireellisyyskategoria on onnistuneesti lisätty tietokantaan."));
            redirectTo('index.php');
        }
        showView('views/urgencyCategoryCreation.php', array('admin' => $admin,
            'personnelcategories' => $prcategories, 'formTitle' => 'Kiireellisyyskategorian lisäys'));
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate(array('admin' => $user->isAdmin()));
    }
} else {
    redirectTo('../kirjautuminen.php');
}

