<?php

class StaffingCalendarView {

    /**
     * @param type $urgencyCategory Currently selected category.
     * @param type $urgencyCategories All categories.
     */
    public function displayDropdownMenu($urgencyCategory, $urgencyCategories, $date, $hour) {
        ?>
        <div class="dropdown">
            <button class="btn dropdown-toggle sr-only" type="button" id="dropdownMenu1"
                    data-toggle="dropdown" style="width:100px;height:40px;position:relative;">
                        <?php
                        if (isset($urgencyCategory)) {
                            echoToPage($urgencyCategory->getName());
                        }
                        ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <?php foreach ($urgencyCategories as $ucFromArray): ?>
                    <?php if ($urgencyCategory != $ucFromArray) : ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href=
                            "<?php
                            echo "muokkaa.php?ucid=";
                            echo $ucFromArray->getID();
                            echo "&date=";
                            echo $date;
                            echo "&hour=";
                            echo $hour;
                            ?>"
                            >
                            <?php echoToPage($ucFromArray->getName()) ?>
                        </a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        </div>
        <?php
    }

}
