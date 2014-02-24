<?php
$weekDays = array('Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su');
$employee = $data->employee;
$firstname = $employee->getFirstName();
$lastname = $employee->getLastName();
$dates = $data->dates;
$workshifts = $data->workshifts;
?>
<div id="employeeworkshifthours" class="tsoha-listing">
    <h4 style="text-align: center"> <?php echo "$firstname $lastname"; ?>  - työvuorot</h4>
    <ul class="pager">
        <li class="previous"><a href="tyontekija.php?previousWeek">&larr; Edellinen viikko</a></li>
        <li class="">Viikko <?php
            $monday = date('d.m.', strtotime($data->dates[0]));
            $sunday = date('d.m.', strtotime($data->dates[6]));
            $year = date('Y', strtotime($data->dates[6]));
            echo "$monday-$sunday$year";
            ?></li>
        <li class="next"><a href="tyontekija.php?nextWeek">Seuraava viikko &rarr;</a></li>
    </ul>

    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>              
                <th></th>
                <?php for ($dayNumber = 0; $dayNumber < 7; $dayNumber++): ?>
                    <th>
                        <?php
                        echo $weekDays[$dayNumber];
                        echo ' ';
                        echo date('d.m.', strtotime($dates[$dayNumber]));
                        ?>
                    </th>
                <?php endfor; ?>
            </tr>
<!--            <tr>              
                <td>Tunteja:</td>
                <td><div class="text-center">8</div></td>
                <td><div class="text-center">7</div></td>
                <td><div class="text-center">0</div></td>
                <td><div class="text-center">0</div></td>
                <td><div class="text-center">0</div></td>
                <td><div class="text-center">0</div></td>
                <td><div class="text-center">0</div></td>
            </tr>-->
        </thead>
        <tbody>
            <?php for ($hour = 0; $hour < 24; $hour++): ?>
                <tr>
                    <th>
                        <?php
                        date_default_timezone_set('UTC');

                        $formattedFrom = date('H:i', $hour * 60 * 60);
                        $formattedTo = date('H:i', ($hour + 1) * 60 * 60);
                        echo($formattedFrom);
                        echo ("-");
                        echo($formattedTo);
                        ?>
                    </th>
                    <?php for ($dayNumber = 0; $dayNumber < 7; $dayNumber++): ?>
                        <td>
                            <?php
                            $date = date('Y-m-d', strtotime($dates[$dayNumber]));
                            if (isset($workshifts[$date][$formattedFrom])) {
                                ?>
                                <div class="text-center"><span class="glyphicon glyphicon-ok"></span></div>
                                <?php }
                                ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>