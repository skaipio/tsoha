<header>
    <div class ='container'>
        <nav class="col-lg-offset-1 col-lg-10 navbar navbar-default" role="navigation">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="<?php if (isActivePage("/tyovuorolista/omattyovuorot.php")): ?>
                        <?php echo "active";
                    endif;
                    ?>">
                        <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/omattyovuorot.php">Omat työvuorot</a>
                    </li>
                    <?php if ($data->admin): ?>
                        <!--                <li><a href="?type=tyovuorot">Työvuorot</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Henkilöstövahvuus<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Kalenteri</a></li>
                                                <li><a href="#">Kiireellisyysluokat</a></li>
                                            </ul>
                                        </li>-->
                        <li class="<?php if (isActivePage("/tyovuorolista/tyontekijat/index.php")): ?>
                                <?php echo "active";
                            endif;
                            ?>">
                            <a href="http://skaipio.users.cs.helsinki.fi/tyovuorolista/tyontekijat/index.php">Työntekijät</a>
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



