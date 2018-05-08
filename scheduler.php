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
    }
    $events = searchEBR($camp_code, $bldg_code, $room_code);
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
                    <li class="col-xs-4" id="search-courses-tab">
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
                    <div class="row" id="search-courses">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="subj-input">Select Subject</label>
                            <div>
                                <select class="form-control" name="subj-input">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="crse-input">Select Course</label>
                            <div>
                                <select class="form-control" name="crse-input">

                                </select>
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
            $('#search-times').hide();
            $('#search-courses').hide();

            $('#search-rooms-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-rooms-tab').addClass('active');
                $('#search-times-tab').removeClass('active');
                $('#search-courses-tab').removeClass('active');
                $('#search-rooms').show();
                $('#search-times').hide();
                $('#search-courses').hide();
                $('input[name=search]').val("rooms");
            });

            $('#search-times-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-times-tab').addClass('active');
                $('#search-rooms-tab').removeClass('active');
                $('#search-courses-tab').removeClass('active');
                $('#search-times').show();
                $('#search-rooms').hide();
                $('#search-courses').hide();
                $('input[name=search]').val("times");
            });

            $('#search-courses-tab').on('click', function(e) {
                e.preventDefault();

                $('#search-courses-tab').addClass('active');
                $('#search-times-tab').removeClass('active');
                $('#search-rooms-tab').removeClass('active');
                $('#search-courses').show();
                $('#search-times').hide();
                $('#search-rooms').hide();
                $('input[name=search]').val("courses");
            });

            let campInput = $("select[name=camp]");
            let bldgInput = $("select[name=bldg]");
            let roomInput = $("select[name=room]");
            let subjInput = $("select[name=subj]");
            let crseInput = $("select[name=crse]");

            $(function() {
                campInput.load("php/functions.php?ftype=camp");
                subjInput.load("php/functions.php?ftype=subj");
            });

            campInput.on('change', function () {
                bldgInput.load("php/functions.php?ftype=bldg&camp=" + campInput.val());
                roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
            }).trigger("change");

            bldgInput.on('change', function () {
                roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
            }).trigger("change");

            subjInput.on('change', function () {
                crseInput.load("php/functions.php?ftype=crse&subj=" + subjInput.val());
            }).trigger("change");
        });
    </script>

</body>

</html>