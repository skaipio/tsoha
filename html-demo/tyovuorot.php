<div id="tyovuorolistat">
    <!-- Miten headerit saadaan floattaamaan scrollauksen mukana? -->
    <h4 style="text-align: center">Viikottainen työvuorolista</h4>
    <a href="?type=tyovuorot-muokkaa" style="text-align: center">Muokkaa</a>
    <ul class="pager">
        <li class="previous"><a href="#">&larr; Edellinen viikko</a></li>
        <li><a href="#">Viikko 27.3.-2.4.2014</a></li>
        <li class="next"><a href="#">Seuraava viikko &rarr;</a></li>
    </ul>
    <ul class="nav nav-justified">
        <li class="span active"><a href="#">Ma 27.3.</a></li>
        <li><a href="#">Ti 28.3.</a></li>
        <li><a href="#">Ke 29.3.</a></li>
        <li><a href="#">To 30.3.</a></li> 
        <li><a href="#">Pe 31.3.</a></li>
        <li><a href="#">La 1.4.</a></li>
        <li><a href="#">Su 2.4.</a></li>
    </ul>
    <table id="tyovuorolistaus" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>              
                <th class="tyontekijasarake"></th>
                <th class="halfwrap"><div class="text-center">00:00-01:00</div></th>
        <th class="halfwrap"><div class="text-center">01:00-02:00</div></th>
        <th class="halfwrap"><div class="text-center">02:00-03:00</div></th>
        <th class="halfwrap"><div class="text-center">03:00-04:00</div></th>
        <th class="halfwrap"><div class="text-center">04:00-05:00</div></th>
        <th class="halfwrap"><div class="text-center">05:00-06:00</div></th>
        <th class="halfwrap"><div class="text-center">06:00-07:00</div></th>
        <th class="halfwrap"><div class="text-center">07:00-08:00</div></th>
        <th class="halfwrap"><div class="text-center">08:00-09:00</div></th>
        <th class="halfwrap"><div class="text-center">09:00-10:00</div></th>
        <th class="halfwrap"><div class="text-center">10:00-11:00</div></th>
        <th class="halfwrap"><div class="text-center">11:00-12:00</div></th>
        <th class="halfwrap"><div class="text-center">12:00-13:00</div></th>
        <th class="halfwrap"><div class="text-center">13:00-14:00</div></th>
        <th class="halfwrap"><div class="text-center">14:00-15:00</div></th>
        <th class="halfwrap"><div class="text-center">15:00-16:00</div></th>
        <th class="halfwrap"><div class="text-center">16:00-17:00</div></th>
        <th class="halfwrap"><div class="text-center">17:00-18:00</div></th>
        <th class="halfwrap"><div class="text-center">18:00-19:00</div></th>
        <th class="halfwrap"><div class="text-center">19:00-20:00</div></th>
        <th class="halfwrap"><div class="text-center">20:00-21:00</div></th>
        <th class="halfwrap"><div class="text-center">21:00-22:00</div></th>
        <th class="halfwrap"><div class="text-center">22:00-23:00</div></th>
        <th class="halfwrap"><div class="text-center">23:00-24:00</div></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>Väiski Vemmelsääri</td>
                <?php for ($hour = 0; $hour < 7; $hour++): ?>
                    <td></td>
                <?php endfor; ?>
                <?php for ($hour = 7; $hour < 16; $hour++): ?>
                    <td><div class="text-center"><span class="glyphicon glyphicon-ok"></span></div></td>
                <?php endfor; ?>
                <?php for ($hour = 16; $hour < 24; $hour++): ?>
                     <td></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Miss Piggy</td>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <td></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Pepe Le Pew</td>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <td></td>
                <?php endfor; ?>
            </tr>

        </tbody>
    </table>
</div>

<!--<script>
    $(function() {
        var $table = $('.table');
        //Make a clone of our table
        var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');

        //Remove everything except for first column
        $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();

        //Match the height of the rows to that of the original table's
        $fixedColumn.find('tr').each(function(i, elem) {
            $(this).height($table.find('tr:eq(' + i + ')').height());
        });
    });
</script>-->