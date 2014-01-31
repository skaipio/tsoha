<!--<script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>-->
<!-- This is a very simple parallax effect achieved by simple CSS 3 multiple backgrounds, made by http://twitter.com/msurguy -->

<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kirjautuminen</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form" action="doLogin.php" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Käyttäjätunnus"
                                       name="sahkoposti" type="text" value="<?php echo $data->sahkoposti;?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Salasana" name="salasana" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me"> Muista minut
                                </label>
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Kirjaudu">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
