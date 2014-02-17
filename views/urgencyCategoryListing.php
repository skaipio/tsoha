<div id="urgencycategory-listing" class="container tsoha-listing">
    <a href="lisaa.php"><button class="btn btn-default" type="button">Lisää kiireellisyyskategoria</button></a>    
    <table id="tyontekijalista" class="table table-striped table-condensed">
        <thead>
            <tr>              
                <th>Nimi</th>
                <?php $personnelcategories = $data->personnelCategories; ?>
                <?php foreach ($personnelcategories as $personnelcategory): ?>
                    <th><?php echo $personnelcategory->getName() ?></th>
                <?php endforeach; ?>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->urgencyCategories as $urgencyCategory): ?>
                <tr>              
                    <td><?php echoToPage($urgencyCategory->urgencyCategory->getName()) ?></td>
                    <?php foreach ($urgencyCategory->minimumPersonnels as $minimumpersonnel): ?>
                        <td><?php echo $minimumpersonnel->getMinimum() ?></td>
                    <?php endforeach; ?>
                    <td>
                        <?php $urgencyCategoryID = $urgencyCategory->urgencyCategory->getId(); ?>
                        <a href="<?php echo "muokkaa.php?id=$urgencyCategoryID" ?>" class="btn btn-default btn-sm" role="button">Muokkaa</a>
                        <a href="<?php echo "poista.php?id=$urgencyCategoryID" ?>" class="btn btn-default btn-sm" role="button">Poista</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

