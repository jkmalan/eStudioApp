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
                            <label for="camp-input">Select Campus</label>
                            <div>
                                <select class="form-control" name="camp-input">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="bldg-input">Select Building</label>
                            <div>
                                <select class="form-control" name="bldg-input">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="room-input">Select Room</label>
                            <div>
                                <select class="form-control" name="room-input">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="search-times">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="date-input">Select Date</label>
                            <div>
                                <input class="form-control" type="date" name="date-input" value="">
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="time-input">Select Time</label>
                            <div>
                                <input class="form-control" type="time" name="time-input" value="">
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="datetime-input">Select Time</label>
                            <div>
                                <input class="form-control" type="datetime-local" name="datetime-input" value="">
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
                    <button class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit">Search</button>
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

            let campInput = $("select[name=camp-input]");
            let bldgInput = $("select[name=bldg-input]");
            let roomInput = $("select[name=room-input]");
            let subjInput = $("select[name=subj-input]");
            let crseInput = $("select[name=crse-input]");

            $(function() {
                campInput.load("php/functions.php?ftype=camp");
                subjInput.load("php/functions.php?ftype=subj");
            });

            campInput.on('change', function () {
                bldgInput.load("php/functions.php?ftype=bldg&campus=" + campInput.val());
                roomInput.load("php/functions.php?ftype=room&building=" + bldgInput.val());
            }).trigger("change");

            bldgInput.on('change', function () {
                roomInput.load("php/functions.php?ftype=room&building=" + bldgInput.val());
            }).trigger("change");

            subjInput.on('change', function () {
                crseInput.load("php/functions.php?ftype=crse&subject=" + subjInput.val());
            }).trigger("change");
        });
    </script>

</body>

</html>