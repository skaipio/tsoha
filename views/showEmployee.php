<div class="container employee-view">
    <div class="col-lg-offset-2 col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php
                    $personnelCategoryName = htmlspecialchars($data->personnelCategory->getName());
                    $employee = $data->employee;
                    $firstname = htmlspecialchars($employee->getFirstName());
                    $lastname = htmlspecialchars($employee->getLastName());
                    echo "$personnelCategoryName $firstname $lastname";
                    ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-5">Henkilötunnus:</label>
                        <span class="col-lg-6"><?php echoToPage($employee->getSSN()) ?></span>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-lg-4">Osoite:</label>
                        <span class="col-lg-8"><?php echoToPage($employee->getAddress()) ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-5 control-label">Sähköposti:</label>
                        <span class="col-lg-6"><?php echoToPage($employee->getEmail()) ?></span>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-lg-4 control-label">Puhelin:</label>
                        <span class="col-lg-8"><?php echoToPage($employee->getPhone()) ?></span>
                    </div>
                </div>
                <div class="row"></div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <label class="col-lg-7">Max tunnit viikossa:</label>
                        <span class="col-lg-3"><?php echoToPage($employee->getMaxHoursPerWeek()) ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-lg-6">Ylläpito-oikeudet:</label>
                        <?php $admin = ($employee->isAdmin()) ? "On" : "Ei ole"; ?>
                        <span class="col-lg-5"><?php echo $admin ?></span>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-lg-7">Max tunnit päivässä</label>
                            <span class="col-lg-3"><?php echoToPage($employee->getMaxHoursPerDay()) ?></span>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-lg-6">
                        <?php $id=$employee->getID();?>
                        <a href="<?php echo "muokkaa.php?id=$id" ?>"><button type="button" class="btn btn-default">Muokkaa</button></a> 
                        <a href="<?php echo "poista.php?id=$id" ?>"><button type="button" class="btn btn-default">Poista työntekijä</button></a>
                        <a href="index.php"><button class="btn btn-default" type="cancel">Takaisin</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>