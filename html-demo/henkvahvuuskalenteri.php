<div id="henkilostovahvuuskalenteri">
    <!-- Miten headerit saadaan floattaamaan scrollauksen mukana? -->
    <h4 style="text-align: center">Henkilöstövahvuuskalenteri</h4>
    <a href="?type=henkvahvuuskalenteri-muokkaa" style="text-align: center">Muokkaa</a>
    <ul class="pager">
        <li class="previous disabled"><a href="#">&larr; Edellinen viikko</a></li>
        <li class="disabled"><a href="#">Viikko 27.3.-2.4.2014</a></li>
        <li class="next disabled"><a href="#">Seuraava viikko &rarr;</a></li>
    </ul>
    <table id="vahvuuslistaus" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>              
                <td>Tuntiväli</td>
                <td><div class="text-center">Ma 27.3.2014</div></td>
                <td><div class="text-center">Ti 28.3.2014</div></td>
                <td><div class="text-center">Ke 29.3.2014</div></td>
                <td><div class="text-center">To 30.3.2014</div></td>
                <td><div class="text-center">Pe 31.3.2014</div></td>
                <td><div class="text-center">La 1.4.2014</div></td>
                <td><div class="text-center">Su 2.4.2014</div></td>
            </tr>

        </thead>
        <tbody>
            <?php for ($hour = 0; $hour < 8; $hour++): ?>
                <tr>
                    <th>
                        <?php
                        $nexthour = $hour + 1;
                        if ($hour < 9) {
                            echo "0$hour:00-0$nexthour:00";
                        } else if ($hour == 9) {
                            echo "0$hour:00-$nexthour:00";
                        } else {
                            echo "$hour:00-$nexthour:00";
                        }
                        ?>
                    </th>
                    <?php for ($weekday = 0; $weekday < 7; $weekday++): ?>
                        <td style="text-align: center"></td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            <?php for ($hour = 8; $hour < 22; $hour++): ?>
                <tr>
                    <th>
                        <?php
                        $nexthour = $hour + 1;
                        if ($hour < 9) {
                            echo "0$hour:00-0$nexthour:00";
                        } else if ($hour == 9) {
                            echo "0$hour:00-$nexthour:00";
                        } else {
                            echo "$hour:00-$nexthour:00";
                        }
                        ?>
                    </th>
                    <?php for ($weekday = 0; $weekday < 7; $weekday++): ?>
                        <td style="text-align: center">L2</td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            <?php for ($hour = 22; $hour < 24; $hour++): ?>
                <tr>
                    <th>
                        <?php
                        $nexthour = $hour + 1;
                        if ($hour < 9) {
                            echo "0$hour:00-0$nexthour:00";
                        } else if ($hour == 9) {
                            echo "0$hour:00-$nexthour:00";
                        } else {
                            echo "$hour:00-$nexthour:00";
                        }
                        ?>
                    </th>
                    <?php for ($weekday = 0; $weekday < 7; $weekday++): ?>
                        <td style="text-align: center"></td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>