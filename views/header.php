<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php
            if (isset($title)) {
                echo $title;
            }
            ?></title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <?php if (!empty($data->error)): ?>
            <div class="alert alert-danger"><?php echo $data->error; ?></div>
        <?php endif; ?>

