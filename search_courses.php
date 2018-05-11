<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "scheduler.css";
$page_title = "Scheduler: Course";

$term_code = $crn_key = "";
$events = array();
if (isset($_GET['submit'])) {
    $term_code = filter_input(INPUT_GET, 'term');
    $crn_key = filter_input(INPUT_GET, 'crn');
    $events = searchEBC($term_code, $crn_key);
}

?>
<html>

<?php include ROOT_DIR . 'php/template/head_template.php'; ?>

<body>

<?php include ROOT_DIR . 'php/template/navigation_template.php'; ?>

<main>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span>CRN Search<span>
            </div>
            <div class="panel-body">
                <form class="crn-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" novalidate>
                    <div class="form-row" id="search-crn">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="term">Select Term</label>
                            <div>
                                <select class="form-control" name="term">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="crn">Enter CRN</label>
                            <div>
                                <input class="form-control" type="text"name="crn" required>
                            </div>
                        </div>
                    <input class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit" name="submit">
                </form>
            </div>
            <hr />
            <div class="panel-body" id="results">
                <div class="row text-center">
                <?php

                /* Desktop headers */
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>Campus<hr></span>";
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>Building<hr></span>";
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>Room<hr></span>";
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>Date<hr></span>";
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>Start Time<hr></span>";
                echo "<span class='col-md-2 col-lg-2 hidden-xs hidden-sm'>End Time<hr></span>";

                /* Mobile headers */
                echo "<span class='col-sm-2 hidden-xs hidden-md hidden-lg'>Camp<hr></span>";
                echo "<span class='col-sm-2 hidden-xs hidden-md hidden-lg'>Bldg<hr></span>";
                echo "<span class='col-xs-3 col-sm-2 hidden-md hidden-lg'>Room<hr></span>";
                echo "<span class='col-xs-3 col-sm-2 hidden-md hidden-lg'>Date<hr></span>";
                echo "<span class='col-xs-3 col-sm-2 hidden-md hidden-lg'>Start<hr></span>";
                echo "<span class='col-xs-3 col-sm-2 hidden-md hidden-lg'>End<hr></span>";
                foreach ($events as $event) {

                    /* Desktop display */
                    echo "<span class='col-lg-2 hidden-xs hidden-sm hidden-md text-nowrap'>" . $event['camp_name'] . "</span>";
                    echo "<span class='col-lg-2 hidden-xs hidden-sm hidden-md text-nowrap'>" . $event['bldg_name'] . "</span>";
                    echo "<span class='col-xs-3 col-lg-2 hidden-sm hidden-md text-nowrap'>" . $event['room_name'] . "</span>";
                    echo "<span class='col-lg-2 hidden-xs hidden-sm hidden-md text-nowrap'>" . explode(' ',$event['time_start'])[0] . "</span>";
                    echo "<span class='col-lg-2 hidden-xs hidden-sm hidden-md text-nowrap'>" . explode(' ',$event['time_start'])[1] . "</span>";
                    echo "<span class='col-lg-2 hidden-xs hidden-sm hidden-md text-nowrap'>" . explode(' ',$event['time_end'])[1] . "</span>";

                    /* Mobile display */
                    echo "<span class='col-sm-2 col-md-2 hidden-xs hidden-lg text-nowrap'>" . $event['camp_code'] . "</span>";
                    echo "<span class='col-sm-2 col-md-2 hidden-xs hidden-lg text-nowrap'>" . $event['bldg_code'] . "</span>";
                    echo "<span class='col-sm-2 col-md-2 hidden-xs hidden-lg text-nowrap'>" . $event['room_code'] . "</span>";
                    echo "<span class='col-xs-3 col-sm-2 col-md-2 hidden-lg text-nowrap'>" . explode(' ',$event['time_start'])[0] . "</span>";
                    echo "<span class='col-xs-3 col-sm-2 col-md-2 hidden-lg text-nowrap'>" . explode(' ',$event['time_start'])[1] . "</span>";
                    echo "<span class='col-xs-3 col-sm-2 col-md-2 hidden-lg text-nowrap'>" . explode(' ',$event['time_end'])[1] . "</span>";
                }

                ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">
    $(function() {
        'use strict';

        let termInput = $("select[name=term]");

        termInput.load("php/functions.php?ftype=term");
    });
</script>

</body>

</html>
