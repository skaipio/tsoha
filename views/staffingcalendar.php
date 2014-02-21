<div id="henkilostovahvuuskalenteri" class="container-fluid tsoha-listing">
    <h4 class="text-center">Henkilöstövahvuuskalenteri - <a href="#">Muokkaa</a></h4>

    <ul class="pager">
        <li class="previous"><a href="index.php?previousWeek">&larr; Edellinen viikko</a></li>
        <li class="disabled"><a href="#">Viikko <?php
                $monday = date('d.m.', strtotime($data->dates[0]));
                $sunday = date('d.m.', strtotime($data->dates[6]));
                $year = date('Y', strtotime($data->dates[6]));
                echo "$monday-$sunday$year";
                ?></a></li>
        <li class="next"><a href="index.php?nextWeek">Seuraava viikko &rarr;</a></li>
    </ul>
    <table id="vahvuuslistaus" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>              
                <th></th>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <th>
                        <?php
                        $nexthour = $hour + 1;
                        if ($hour < 9) {
                            $formattedHour = "0$hour:00-0$nexthour:00";
                        } else if ($hour == 9) {
                            $formattedHour = "0$hour:00-$nexthour:00";
                        } else {
                            $formattedHour = "$hour:00-$nexthour:00";
                        }
                        echo $formattedHour;
                        ?>
                    </th>

                <?php endfor; ?>

            </tr>
        </thead>
        <tbody>
            <?php for ($weekday = 0; $weekday < 7; $weekday++): ?>
                <tr>
                    <?php $date = $data->dates[$weekday]; ?>
                    <th><div class="text-center"><?php echo date('D d.m.', strtotime($date)) ?></div></th>
            <?php for ($hour = 0; $hour < 24; $hour++): ?>
                <td style="text-align: center">
                    <?php
                    $date = date('Y-m-d', strtotime($date));
                    $hourKey = date('H:00', mktime($hour));
                    if (isset($data->openHours[$date])) {
                        if (isset($data->openHours[$date][$hourKey])) {
                            $openHour = $data->openHours[$date][$hourKey];
                            $urgencyCategories = $data->urgencyCategories;
                            echoToPage($urgencyCategories[$openHour->getUrgencyCategoryID()]->getName());
                        }
                    }
                    ?>
                </td>
            <?php endfor; ?>
            </tr>
            <?php foreach ($data->personnelCategories as $personnelCategory): ?>
                <tr>
                    <td><div class=""><?php echoToPage($personnelCategory->getName()) ?></div></td>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <td style="text-align: center">
                            <?php
                            $date = date('Y-m-d', strtotime($date));
                            $hourKey = date('H:00', mktime($hour));
                            if (isset($data->openHours[$date])) {
                                if (isset($data->openHours[$date][$hourKey])) {
                                    $openHour = $data->openHours[$date][$hourKey];
                                    $urgencyCategories = $data->urgencyCategories;
                                    $urgencyCategory = $urgencyCategories[$openHour->getUrgencyCategoryID()];
                                    $minimumPersonnels = $urgencyCategory->getMinimumPersonnels();
                                    $minimum = $minimumPersonnels[$personnelCategory->getID()];
                                    echo($minimum);
                                }
                            }
                            ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach ?>
        <?php endfor ?>
        </tbody>
    </table>
</div>