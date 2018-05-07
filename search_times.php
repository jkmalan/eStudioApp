<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "scheduler.css";
$page_title = "Scheduler: Time";

$time_start = $time_end = "";
$events = array();
if (isset($_GET['submit'])) {
    $time_start = filter_input(INPUT_GET, 'time-start');
    $time_end = filter_input(INPUT_GET, 'time-end');
    $events = searchEBT($time_start, $time_end);
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
                <span>Time Search<span>
            </div>
            <div class="panel-body">
                <form class="time-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" novalidate>
                    <div class="form-row" id="search-times">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="time-start">Select Start Time</label>
                            <div id="time-start-picker">
                                <input class="form-control" type="datetime-local" name="time-start" required>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="time-end">Select End Time</label>
                            <div id="time-end-picker">
                                <input class="form-control" type="datetime-local" name="time-end" required>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit" name="submit">
                </form>
            </div>
            <hr />
            <div class="panel-body" id="results">
                <div class="row">
                <?php

                foreach ($events as $event) {
                    echo "<div class='col-xs-6 col-sm-4 col-lg-3 btn btn-secondary'>" . $event['bldg_name']  . " RM" . $event['room_code'] . "</div>";
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

    });
</script>

</body>

</html>
