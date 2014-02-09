<div class='container'>
    <?php if (isset($_SESSION['notification'])): ?>  
        <div class ="col-lg-offset-2 col-lg-8 alert alert-success">
            <?php echo $_SESSION['notification']; ?>
        </div>
        <?php unset($_SESSION['notification']); ?>
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
    <?php endif; ?>
</div>

