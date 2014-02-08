<div id="employee-add" class="container">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo "$data->personnelcategory $data->firstname $data->lastname" ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-5">Henkilötunnus:</label>
                        <span class="col-lg-6"><?php echo htmlspecialchars($data->ssn) ?></span>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-lg-4">Osoite:</label>
                        <span class="col-lg-8"><?php echo htmlspecialchars($data->address) ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-5 control-label">Sähköposti:</label>
                        <span class="col-lg-6"><?php echo htmlspecialchars($data->email) ?></span>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-lg-4 control-label">Puhelin:</label>
                        <span class="col-lg-8"><?php echo htmlspecialchars($data->phone) ?></span>
                    </div>
                </div>
                <div class="row"></div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <label class="col-lg-7">Max tunnit viikossa:</label>
                        <span class="col-lg-3"><?php echo htmlspecialchars($data->maxhoursperweek) ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-6">Ylläpito-oikeudet:</label>
                        <?php $admin = ($data->admin) ? "On" : "Ei ole"; ?>
                        <span class="col-lg-5"><?php echo $admin ?></span>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-7">Max tunnit päivässä</label>
                            <span class="col-lg-3"><?php echo htmlspecialchars($data->maxhoursperday) ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <a href="<?php echo "muokkaa.php?id=$data->id" ?>"><button type="button" class="btn btn-default">Muokkaa</button></a> 
                        <button type="submit" class="btn btn-default">Poista työntekijä</button></a>
                        <a href="../tyontekijat.php"><button class="btn btn-default" type="cancel">Takaisin</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>