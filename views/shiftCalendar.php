<div id="henkilostovahvuuskalenteri" class="container-fluid tsoha-listing">
    <?php
    $shiftCalendarView = new ShiftCalendarView();
    ?>
    <h4 class="text-center">
        Työvuorot - 
        <?php if (!isset($data->modify)): ?>
            <a href="muokkaa.php?">Muokkaa</a>
        <?php else: ?>
            <a href="tallenna.php">Tallenna</a> - <a href="index.php">Peruuta</a>
        <?php endif; ?>
    </h4>

    <?php if (!isset($data->modify)): ?>
        <ul class="pager">
            <li class="previous"><a href="index.php?previousWeek">&larr; Edellinen viikko</a></li>
            <li class="">Viikko <?php
                $monday = date('d.m.', strtotime($data->dates[0]));
                $sunday = date('d.m.', strtotime($data->dates[6]));
                $year = date('Y', strtotime($data->dates[6]));
                echo "$monday-$sunday$year";
                ?></li>
            <li class="next"><a href="index.php?nextWeek">Seuraava viikko &rarr;</a></li>
        </ul>
    <?php endif; ?>

    <?php $shiftCalendarView->displayWeekdayNavPills($data->dayViewed, $data->dates, $data->modify) ?>
    <?php $shiftCalendarView->displayEmployeeTable($data->employees, $data->personnelCategories,
            $data->workshifts, $data->modify, $data->dateViewed, $data->openHours) ?>
</div>