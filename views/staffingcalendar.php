<div id="henkilostovahvuuskalenteri" class="container-fluid tsoha-listing">
    <?php
    $staffingCalendarView = new StaffingCalendarView();
    $urgencyCategories = $data->urgencyCategories;
    ?>
    <h4 class="text-center">
        Henkilöstövahvuuskalenteri - 
        <?php if (!isset($data->modify)): ?>
            <a href="muokkaa.php">Muokkaa</a>
        <?php else: ?>
            <a href="tallenna.php">Tallenna</a> - <a href="index.php">Peruuta</a>
        <?php endif; ?>
    </h4>

    <?php if (!isset($data->modify)): ?>
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
    <?php endif; ?>

    <table id="vahvuuslistaus" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>              
                <th></th>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <th class="headerRow">
                        <?php
                        $nexthour = $hour + 1;
                        $nexthour = date('H:i', $nexthour*60*60);
                        $formattedHour = date('H:i', $hour*60*60);
                        echo($formattedHour);echo ("-"); echo($nexthour);
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
                    $hourKey = date('H:i', $hour*60*60);
                    ?>
                    <?php
                    if (isset($data->openHours[$date]) && isset($data->openHours[$date][$hourKey])) {
                        $openHour = $data->openHours[$date][$hourKey];
                        $urgencyCategory = $urgencyCategories[$openHour->getUrgencyCategoryID()];
                    } else {
                        unset($urgencyCategory);
                    }
                    if (isset($data->modify)) {
                        if (isset($urgencyCategory)) {
                            $staffingCalendarView->displayDropdownMenu($urgencyCategory, $urgencyCategories, $date, $hourKey);
                        } else {
                            $staffingCalendarView->displayDropdownMenu(null, $urgencyCategories, $date, $hourKey);
                        }
                    } else if (isset($urgencyCategory)) {
                        echoToPage($urgencyCategory->getName());
                    }
                    ?>
                </td>
            <?php endfor;
            ?>
            </tr>
            <?php foreach ($data->personnelCategories as $personnelCategory): ?>
                <tr>
                    <td><div class=""><?php echoToPage($personnelCategory->getName()) ?></div></td>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <td style="text-align: center">
                            <?php
                            $date = date('Y-m-d', strtotime($date));
                            $hourKey = date('H:i', $hour*60*60);
                            if (isset($data->openHours[$date])) {
                                if (isset($data->openHours[$date][$hourKey])) {
                                    $openHour = $data->openHours[$date][$hourKey];
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