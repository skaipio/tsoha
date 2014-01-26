<div id="tyovuorot-muokkaus">
    <!-- Miten headerit saadaan floattaamaan scrollauksen mukana? -->
    <h4 style="text-align: center">Muokkaa työvuoroja - Viikko 27.3.-2.4.2014</h4>
    <div class="btn-toolbar col-md-2">
        <div class="btn-group">
            <a href=1 class="btn btn-small disabled">Tallenna työvuorot</a>
            <a href="?type=tyovuorot" class="btn btn-small">Peruuta</a>
        </div>
    </div>
    <ul class="nav nav-justified nav-pills">
        <li class="active"><a href="#">Ma 27.3.</a></li>
        <li class="disabled"><a href="#">Ti 28.3.</a></li>
        <li class="disabled"><a href="#">Ke 29.3.</a></li>
        <li class="disabled"><a href="#">To 30.3.</a></li> 
        <li class="disabled"><a href="#">Pe 31.3.</a></li>
        <li class="disabled"><a href="#">La 1.4.</a></li>
        <li class="disabled"><a href="#">Su 2.4.</a></li>
    </ul>
    <table id="tyovuorolista-muokattava" class="table table-striped table-bordered table-condensed">
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
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox">
                            </span>
                        </div>
                    </td>
                <?php endfor; ?>
                <?php for ($hour = 7; $hour < 16; $hour++): ?>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" class="checked">
                            </span>
                        </div>
                    </td>
                <?php endfor; ?>
                <?php for ($hour = 16; $hour < 24; $hour++): ?>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox">
                            </span>
                        </div>
                    </td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Miss Piggy</td>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox">
                            </span>
                        </div>
                    </td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td>Pepe Le Pew</td>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox">
                            </span>
                        </div>
                    </td>
                <?php endfor; ?>
            </tr>

        </tbody>
    </table>
</div>