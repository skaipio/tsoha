<div class='container'>
    <?php if (session_is_registered('successes')): ?>  
        <div class ="col-lg-offset-2 col-lg-8 alert alert-success">
            <?php            
            $successes = $_SESSION['successes'];
            echoNotifications($successes);
            ?>
        </div>
        <?php unset($_SESSION['successes']); ?>
    <?php endif; ?>
    <?php if (session_is_registered('warnings')): ?>  
        <div class ="col-lg-offset-2 col-lg-8 alert alert-warning">
            <?php
            $warnings = $_SESSION['warnings'];
            echoNotifications($warnings);
            ?>
        </div>
        <?php unset($_SESSION['warnings']); ?>
    <?php endif; ?>
    <?php if (session_is_registered('errors')): ?>  
        <div class ="col-lg-offset-2 col-lg-8 alert alert-danger">
            <?php
            $errors = $_SESSION['errors'];
            echoNotifications($errors);
            ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
</div>

