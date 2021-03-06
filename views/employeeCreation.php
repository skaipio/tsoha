<div class="container employee-view">
    <div class="col-lg-offset-1 col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echoToPage($data->formTitle) ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="employee-add-form" class="form-horizontal" role="form" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="firstname" class="col-lg-3 control-label">Etunimi</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="firstname"
                                           name="firstname" value="<?php echoToPage($data->employee->getFirstName()) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="lastname" class="col-lg-3 control-label">Sukunimi</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="lastname"
                                           name="lastname" value="<?php echoToPage($data->employee->getLastName()) ?>">
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="ssn" class="col-lg-3 control-label">Henkilötunnus</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="ssn"
                                           name="ssn"value="<?php echoToPage($data->employee->getSSN()) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="address" class="col-lg-3 control-label">Osoite</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="address"
                                           name="address" value="<?php echoToPage($data->employee->getAddress()) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email" class="col-lg-3 control-label">Sähköposti</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="email"
                                           name="email" value="<?php echoToPage($data->employee->getEmail()) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone" class="col-lg-3 control-label">Puhelin</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="phone"
                                           name="phone" value="<?php echoToPage($data->employee->getPhone()) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="soften">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="personnelcategory_id" class="col-lg-5 control-label">Henkilöstöluokka</label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="personnelcategory_id" name="personnelcategory_id">
                                        <?php $categories = $data->personnelCategories; ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->getID(); ?>" 
                                            <?php
                                            if (isset($data->employee) && $data->employee->getPersonnelCategoryID() == $category->getID()) {
                                                echo ' selected';
                                            }
                                            ?>>
                                                        <?php echo $category->getName() ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="maxhoursperweek" class="col-lg-5 control-label">Max tunnit viikossa</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="maxhoursperweek"
                                           name="maxhoursperweek" value="<?php echoToPage($data->employee->getMaxHoursPerWeek()) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Ylläpito-oikeudet</label>
                                <div class="col-lg-6">
                                    <label class="checkbox">
                                        <input type="checkbox" id="Admin"
                                               name="Admin" value='true'
                                               <?php
                                               if (isset($data->Admin) && $data->employee->isAdmin()) {
                                                   echo 'checked';
                                               }
                                               ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="maxhoursperday" class="col-lg-5 control-label">Max tunnit päivässä</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="maxhoursperday"
                                           name="maxhoursperday" value="<?php echoToPage($data->employee->getMaxHoursPerDay()) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-8">
                                <button type="submit" class="btn btn-default">Tallenna</button>
                                <a href="index.php"><button class="btn btn-default" type="button">Peruuta</button></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>