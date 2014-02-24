<header>
    <div class ='container'>
        <nav class="col-lg-offset-1 col-lg-10 navbar navbar-default" role="navigation">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="<?php if (isActivePage("/tyovuorolista/tyovuorot/tyontekija.php")): ?>
                        <?php echo "active";
                    endif;
                    ?>">
                        <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/tyovuorot/tyontekija.php">Omat työvuorot</a>
                    </li>
                    <?php if (isset($data->admin) && $data->admin): ?>
                        <li class="<?php if (isActivePage("/tyovuorolista/tyontekijat/index.php")): ?>
                                <?php echo "active";
                            endif;
                            ?>">
                            <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/tyontekijat/index.php">Työntekijät</a>
                        </li>
                        <li class="<?php if (isActivePage("/tyovuorolista/kiireellisyyskategoriat/index.php")): ?>
                                <?php echo "active";
                            endif;
                            ?>">
                            <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/kiireellisyyskategoriat/index.php">Kiireellisyyskategoriat</a>
                        </li>
                        <li class="<?php if (isActivePage("/tyovuorolista/henkilostovahvuus/index.php")): ?>
                                <?php echo "active";
                            endif;
                            ?>">
                            <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/henkilostovahvuus/index.php">Henkilöstövahvuuskalenteri</a>
                        </li>
                        <li class="<?php if (isActivePage("/tyovuorolista/tyovuorot/index.php")): ?>
                                <?php echo "active";
                            endif;
                            ?>">
                            <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/tyovuorot/index.php">Työvuorot</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/index.php?logout">Kirjaudu ulos</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<script src="/tyovuorolista/js/jquery.js"></script>
<script src="/tyovuorolista/js/bootstrap.js"></script>



