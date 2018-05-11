<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "scheduler.css";
$page_title = "Scheduler";

/*
 * Handles self submit form data and redirects to appropriate search page
 */
$time_start = $time_end = "";
$camp_code = $bldg_code = $room_code = "";
if (isset($_GET['submit'])) {
    $search = filter_input(INPUT_GET, 'search');
    if ($search === "rooms") {
        $camp_code = filter_input(INPUT_GET, 'camp');
        $bldg_code = filter_input(INPUT_GET, 'bldg');
        $room_code = filter_input(INPUT_GET, 'room');
        header('Location: ' . BASE_URL . 'search_rooms.php?camp=' . $camp_code . '&bldg=' . $bldg_code . '&room=' . $room_code . '&submit=Submit');
        exit();
    } else if ($search === "times") {
        $time_start = filter_input(INPUT_GET, 'time-start');
        $time_end = filter_input(INPUT_GET, 'time-end');
        header('Location: ' . BASE_URL . 'search_times.php?time-start=' . $time_start . '&time-end=' . $time_end . '&submit=Submit');
        exit();
    } else if ($search === "terms") {
        $term_code = filter_input(INPUT_GET, 'term');
        $crn_key = filter_input(INPUT_GET, 'crn');
        header('Location: ' . BASE_URL . 'search_courses.php?term=' . $term_code . '&crn=' . $crn_key . '&submit=Submit');
        exit();
    }
}

?>
<html>

<?php include ROOT_DIR . 'php/template/head_template.php'; ?>

<body>

<?php include ROOT_DIR . 'php/template/navigation_template.php'; ?>

    <main>
        <div class="container">
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="col-xs-4 active" id="search-rooms-tab">
                        <a class="" href="JavaScript:void(0);">Rooms</a>
                    </li>
                    <li class="col-xs-4" id="search-times-tab">
                        <a class="" href="JavaScript:void(0);">Times</a>
                    </li>
                    <li class="col-xs-4" id="search-crn-tab">
                        <a class="" href="JavaScript:void(0);">Courses</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <input type="hidden" name="search" value="rooms">
                    <div class="row" id="search-rooms">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="camp">Select Campus</label>
                            <div>
                                <select class="form-control" name="camp">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="bldg">Select Building</label>
                            <div>
                                <select class="form-control" name="bldg">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="room">Select Room</label>
                            <div>
                                <select class="form-control" name="room">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="search-times">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="time-start">Select Start Time</label>
                            <div>
                                <input class="form-control" type="datetime-local" name="time-start" value="">
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="time-end">Select End Time</label>
                            <div>
                                <input class="form-control" type="datetime-local" name="time-end" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="search-crn">
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
                                <input type="text" class="form-control" name="crn">
                            </div>
                        </div>
                    </div>
                    <input type="text" name="search" value="rooms" hidden>
                    <input class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit" name="submit">
                </form>
            </div>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

    <script type="text/javascript">
        $(function() {
            /* Handles switching between search tabs and search page redirect */
            $('#search-times').hide();
            $('#search-crn').hide();

            $('#search-rooms-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-rooms-tab').addClass('active');
                $('#search-times-tab').removeClass('active');
                $('#search-crn-tab').removeClass('active');
                $('#search-rooms').show();
                $('#search-times').hide();
                $('#search-crn').hide();
                $('input[name=search]').val("rooms");
            });

            $('#search-times-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-times-tab').addClass('active');
                $('#search-rooms-tab').removeClass('active');
                $('#search-crn-tab').removeClass('active');
                $('#search-times').show();
                $('#search-rooms').hide();
                $('#search-crn').hide();
                $('input[name=search]').val("times");
            });

            $('#search-crn-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-crn-tab').addClass('active');
                $('#search-times-tab').removeClass('active');
                $('#search-rooms-tab').removeClass('active');
                $('#search-crn').show();
                $('#search-times').hide();
                $('#search-rooms').hide();
                $('input[name=search]').val("terms");
            });

            /* Handles select tag option loading through AJAX calls to functions.php */
            let campInput = $("select[name=camp]");
            let bldgInput = $("select[name=bldg]");
            let roomInput = $("select[name=room]");
            let termInput = $("select[name=term]");

            campInput.load("php/functions.php?ftype=camp");
            termInput.load("php/functions.php?ftype=term");

            campInput.on('change', function () {
                bldgInput.load("php/functions.php?ftype=bldg&camp=" + campInput.val());
                roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
            }).trigger("change");

            bldgInput.on('change', function () {
                roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
            }).trigger("change");
        });
    </script>

</body>

</html>