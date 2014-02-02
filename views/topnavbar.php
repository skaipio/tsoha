<header>
    <nav class="navbar navbar-default" role="navigation">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="omattyovuorot.php">Omat työvuorot</a></li>
                <?php if ($data->isadmin):?>
<!--                <li><a href="?type=tyovuorot">Työvuorot</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Henkilöstövahvuus<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Kalenteri</a></li>
                        <li><a href="#">Kiireellisyysluokat</a></li>
                    </ul>
                </li>-->
                <li><a href="tyontekijalista.php">Työntekijät</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php?logout">Kirjaudu ulos</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</header>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>



