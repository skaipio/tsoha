<?php
require_once 'topnavbar.php';
?>

<div id="employees-listing" class="tsoha-listing">
    <a href="lisaaTyontekija.php"><button class="btn btn-default" type="button">Lisää työntekijä</button></a>    
    <table id="tyontekijalista" class="table table-striped table-condensed">
        <thead>
            <tr>              
                <th id="etunimi-header">Etunimi</th>
                <th id="sukunimi-header">Sukunimi</th>
                <th id="henkilosto-header">Henkilöstöluokka</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->employeeDetails as $employee): ?>
                <tr>              
                    <td><?php echo $employee->firstname ?></td>
                    <td><?php echo $employee->lastname ?></td>
                    <td><?php echo $employee->personnelcategory ?></td>
                    <td><a href="#" class="btn">Näytä</a></td>
                    <td>
                        <form action='poistaTyontekija.php' method="post">
                            <input type="hidden" name="id" value="<?php echo $employee->id ?>">
                            <input type="submit" name="delete" value="Poista">
                        </form>
    <!--                    <td><button href="poistaTyontekija.php" class="btn btn-default" type='button' method="delete">Poista</button></td>-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

