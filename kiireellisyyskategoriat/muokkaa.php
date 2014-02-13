<?php

require "../models/urgencycategory.php";
require "../models/minimumpersonnel.php";
require "../libs/common.php";

$user = getUserLoggedIn();
if (isset($user)) {
    setNavBarAsVisible(false);
    $admin = $user->isAdmin();
    if ($admin) {
        $prcategories = getPersonnelCategoriesDataArray();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ucdata = (object) getSubmittedUrgencyCategoryData();
            $uc = $_SESSION['urgencyCategoryModified'];
            var_dump($uc);
            $uc->setFromDataObject($ucdata);
            $minimpDatas = (object) getSubmittedMinimumPersonnelData();
            if ($uc->updateDatabaseEntry()) {
                foreach ($minimpDatas as $pcid => $minimum) {
                    $minimp = MinimumPersonnel::createFromData(array('urgencycategory_id' => $uc->getID(),
                                'personnelcategory_id' => $pcid, 'minimum' => $minimum));
                    if ($minimp->isValid()) {
                        $minimp->updateDatabaseEntry();
                    } else {
                        setErrors($minimp->getErrors());
                        showView('views/urgencyCategoryCreation.php', $uc->getAsDataArray() + array('admin' => $admin,
                            'personnelcategories' => $prcategories, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
                    }
                }
                setSuccesses(array("Kiireellisyyskategoriaa on onnistuneesti muokattu."));
                redirectTo('index.php');
            }
            setErrors(array('Kiireellisyyskategoriaa ei voitu muokata.'));
            redirectTo('index.php');
        }

        $id = $_GET['id'];
        if (empty($id)) {
            redirectTo('index.php');
        }
        $uc = UrgencyCategory::getByID($id);
        if (empty($uc)) {
            setErrors(array('Kiireellisyyskategoriaa ei löytynyt tietokannasta.'));
            redirectTo('index.php');
        }
        foreach ($prcategories as $prcategory) {
            $minimp = MinimumPersonnel::getMinimumPersonnelByUrgencyCategoryAndPersonnelCategory($uc->getID(), $prcategory->id);
            $prcategory->minimum = $minimp->getMinimum();
        }
        $_SESSION['urgencyCategoryModified'] = $uc;
        var_dump($uc);

        showView('views/urgencyCategoryCreation.php', $uc->getAsDataArray() + array('admin' => $admin,
            'personnelcategories' => $prcategories, 'formTitle' => 'Kiireellisyyskategorian muokkaus'));
    } else {
        setErrors(array("Sivu vaatii ylläpito-oikeudet."));
        showOnlyTemplate(array('admin' => $user->isAdmin()));
    }
} else {
    redirectTo('../kirjautuminen.php');
}

