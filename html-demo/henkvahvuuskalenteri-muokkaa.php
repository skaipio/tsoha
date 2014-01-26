<div id="henkilostovahvuuskalenteri">
    <!-- Miten headerit saadaan floattaamaan scrollauksen mukana? -->
    <h4 style="text-align: center">Muokkaa henkilöstövahvuuskalenteria - Viikko 27.3.-2.4.2014</h4>
    <div class="btn-toolbar col-md-4">
        <div class="btn-group">
            <a href=1 class="btn btn-small disabled">Tallenna muutokset</a>
            <a href=1 class="btn btn-small disabled">Kopioi edellisen viikon aukioloajat</a>
            <a href="?type=henkvahvuuskalenteri" class="btn btn-small">Peruuta</a>
        </div>
    </div>
    <table id="vahvuuslistaus-muokattava" class="table table-striped table-bordered table-condensed">
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
            <?php for ($hour = 0; $hour < 24; $hour++): ?>
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
                        <td><select class="form-control">
                                <option></option>
                                <option>L2</option>
                                <option>L3</option>
                            </select></td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>