<?php

function showView($sivu, $data = array()) {
    $data = (object) $data;
    require_once 'views/header.php';
    require_once 'views/topnavbar.php';
    require_once $sivu;
    require_once 'views/footer.php';
    exit();
}

function postParamsExist($params = array()) {
    foreach ($params as $param) {
        if (empty($_POST[$param])) {
            return false;
        }
    }
    return true;
}
