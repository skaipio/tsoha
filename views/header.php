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
        <?php if (isset($_SESSION['notification'])): ?>  
        var_dump($_SESSION['notification');
        <div class ="alert alert-danger">
            <?php echo $_SESSION['notification']; ?>
        </div>
        <?php
            unset($_SESSION['notification']);
        ?>
        <?php endif; ?>
        <?php if (isset($data->errors)): ?>
            <div class="alert alert-danger">
                <?php
                $errors = $data->errors;
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
         endif; 

