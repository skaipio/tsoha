<?php

class ShiftCalendarView {

    private $weekDays = array('Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su');

    /**
     * @param type $urgencyCategory Currently selected category.
     * @param type $urgencyCategories All categories.
     */
    public function displayWeekdayNavPills($selectedDay, $dates, $modify) {
        ?>
        <ul class="nav nav-justified nav-pills">
            <?php for ($dayNumber = 0; $dayNumber < 7; $dayNumber++): ?>
                <li class="<?php if ($dayNumber === (int) $selectedDay) echo 'active' ?>">
                    <a href="<?php
                    if (isset($modify) && $modify) {
                        echo "muokkaa.php?day=$dayNumber";
                    } else {
                        echo "index.php?day=$dayNumber";
                    }
                    ?>">
                           <?php
                           echo $this->weekDays[$dayNumber];
                           echo ' ';
                           echo date('d.m.', strtotime($dates[$dayNumber]));
                           ?>
                    </a></li>
            <?php endfor; ?>
        </ul>
        <?php
    }

    public function displayEmployeeTable($employees, $personnelCategories, $workshifts, $modify, $dateViewed) {
        ?>
        <table id="shiftTable" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>              
                    <th></th>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <th class="headerRow">
                            <?php $this->displayHourRange($hour, $hour + 1) ?>
                        </th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employeeID => $employee):
                    ?>
                    <tr>
                        <td>
                            <?php
                            $category = $personnelCategories[$employee->getPersonnelCategoryID()];
                            $category = $category->getName();
                            $firstname = $employee->getFirstName();
                            $lastname = $employee->getLastName();
                            echoToPage("$category $firstname $lastname");
                            ?>
                        </td>
                        <?php for ($hour = 0; $hour < 24; $hour++): ?>
                            <td>
                                <?php
                                $employeeDates = $workshifts[$employeeID];
                                date_default_timezone_set('UTC');
                                $formattedHour = date('H:i', $hour * 60 * 60);
                                ?>
                                <?php if (isset($employeeDates[$dateViewed]) && isset($employeeDates[$dateViewed][$formattedHour])): ?>
                                    <?php if (isset($modify) && $modify): ?>
                                    <td>
                                        <a><button><div class="text-center"><span class="glyphicon glyphicon-ok"></span></div></button><a>
                                                </td>
                                            <?php else: ?>
                                                <div class="text-center"><span class="glyphicon glyphicon-ok"></span></div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endfor; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>
                                <?php
                            }

                            /**
                             * Displays hour gap in the form XX:00-YY:00 where XX is the from hour
                             * and YY is the to hour.
                             * @param type $from Hour integer 
                             * @param type $to
                             */
                            public function displayHourRange($from, $to) {
                                date_default_timezone_set('UTC');

                                $formattedFrom = date('H:i', $from * 60 * 60);
                                $formattedTo = date('H:i', $to * 60 * 60);
                                echo($formattedFrom);
                                echo ("-");
                                echo($formattedTo);
                            }

                        }
                        