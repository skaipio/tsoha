<div class="container employee-view">
    <div class="col-lg-offset-2 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echoToPage($data->formTitle) ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="urgencycategory-add-form" class="form-horizontal" role="form" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name" class="col-lg-5 control-label">Kiireellisyysluokan nimi</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" id="name"
                                           name="name" value="<?php if (isset($data->name)) {echoToPage($data->name);} ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="soften">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <label for="name" class="col-lg-12">Minimivahvuudet</label>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($data->personnelcategories as $personnelcategory): ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name" class="col-lg-3 control-label"><?php echoToPage($personnelcategory->name) ?></label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="name"
                                               name="<?php echo "minimum_of_$personnelcategory->id"?>"
                                               value="<?php if (isset($data->name)) {echoToPage($personnelcategory->minimum);} ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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