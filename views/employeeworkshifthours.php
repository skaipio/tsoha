<?php
require_once 'topnavbar.php';
$employeeDetails = $data->employeeDetails;
?>
<div id="employeeworkshifthours">
    <h4 style="text-align: center"> <?php echo "$employeeDetails->firstname $employeeDetails->lastname"; ?>  - työvuorot</h4>
    <ul class="pager">
        <li class="disabled"><a href="#">&laquo; Edellinen viikko</a></li>
        <li class="disabled"><a href="#">Viikko 27.3.-2.4.2014</a></li>
        <li class="disabled"><a href="#">Seuraava viikko &raquo;</a></li>
    </ul>
</div>