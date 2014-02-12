<div id="urgencycategory-listing" class="container tsoha-listing">
    <a href="lisaa.php"><button class="btn btn-default" type="button">Lisää kiireellisyyskategoria</button></a>    
    <table id="tyontekijalista" class="table table-striped table-condensed">
        <thead>
            <tr>              
                <th>Nimi</th>
                <?php $personnelcategories = $data->personnelcategories; ?>
                <?php foreach ($personnelcategories as $personnelcategory): ?>
                    <th><?php echo $personnelcategory->name ?></th>
                <?php endforeach; ?>
                <th>Toiminnot</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->urgencycategories as $urgencycategory): ?>
                <tr>              
                    <td><?php echo $urgencycategory->name ?></td>
                    <?php foreach ($urgencycategory->minimumpersonnels as $minimumpersonnel): ?>
                        <td><?php echo $minimumpersonnel->minimum ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="<?php echo "nayta.php?id=$urgencycategory->id" ?>" class="btn btn-default btn-sm" role="button">Näytä</a>
                        <a href="<?php echo "poista.php?id=$urgencycategory->id" ?>" class="btn btn-default btn-sm" role="button">Poista</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

