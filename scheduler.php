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
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="panel-title"><a href="#room-select-panel" data-toggle="collapse">Room Selection</a></h5>
                    </div>
                    <div class="panel-collapse collapse" id="room-select-panel">
                        <div class="panel-body">
                            <form class="form-inline" action="calendar.php" method="get">
                                <div class="form-group">
                                    <label class="sr-only" for="campusInput">Campus</label>
                                    <select class="form-control mb-2" id="campusInput" title="Choose a campus...">

                                    </select>

                                    <label class="sr-only" for="buildingInput">Building</label>
                                    <select class="form-control mb-2" id="buildingInput" title="Choose a building...">

                                    </select>

                                    <label class="sr-only" for="roomInput">Room</label>
                                    <select class="form-control mb-2" id="roomInput" title="Choose a room...">

                                    </select>

                                    <button class="btn btn-primary mb-2" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <h5 class="panel-title"><a href="#professor-select-panel" data-toggle="collapse">Professor Selection</a></h5>
                    </div>
                    <div class="panel-collapse collapse" id="professor-select-panel">
                        <div class="panel-body">
                            <form class="form-inline" action="calendar.php" method="get">
                                <div class="form-group">
                                    <label class="sr-only" for="professorInput">Professor</label>
                                    <select class="form-control mb-4" id="professorInput" title="Choose a professor...">

                                    </select>

                                    <button class="btn btn-primary mb-2" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

    <script type="text/javascript">
        $(function() {
            var $campusInput = $("#campusInput");
            var $buildingInput = $("#buildingInput");
            var $roomInput = $("#roomInput");
            var $professorInput = $("#professorInput");

            $(function() {
                $campusInput.load("php/functions.php?ftype=camp");
                $professorInput.load("php/functions.php?ftype=prof");
            });

            $campusInput.on('change', function () {
                $buildingInput.load("php/functions.php?ftype=bldg&campus=" + $campusInput.val());
                $roomInput.load("php/functions.php?ftype=room&building=" + $buildingInput.val());
            }).trigger("change");

            $buildingInput.on('change', function () {
                $roomInput.load("php/functions.php?ftype=room&building=" + $buildingInput.val());
            }).trigger("change");
        });
    </script>

</body>

</html>