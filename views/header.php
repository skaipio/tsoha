<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php
            if (isset($title)) {
                echo $title;
            }
            ?></title>
        <link href="<?php echo("/tyovuorolista/css/bootstrap.css") ?>" rel="stylesheet">
        <link href="<?php echo("/tyovuorolista/css/bootstrap-theme.css") ?>" rel="stylesheet">
        <link href="<?php echo("/tyovuorolista/css/main.css") ?>" rel="stylesheet">
    </head>
    <body>
        <?php
        $root = $_SERVER['DOCUMENT_ROOT'] . '/tyovuorolista';
        $path = $root . "/views/notifications.php";
        include($path);
        if (isset($data->includeNavBar)) {
            $path = $root . "/views/topnavbar.php";
            include($path);
        }

