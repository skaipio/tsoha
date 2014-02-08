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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->employeeDetails as $employee): ?>
                <tr>              
                    <td><?php echo $employee->firstname ?></td>
                    <td><?php echo $employee->lastname ?></td>
                    <td><?php echo $employee->personnelcategory ?></td>
                    <td><a href="?type=tyontekija" class="btn">Näytä</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

