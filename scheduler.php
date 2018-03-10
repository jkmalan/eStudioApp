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
                            <form action="" method="get">
                                <div class="form-group">
                                    <label for="campusInput">Campus</label>
                                    <select class="form-control selectpicker" id="campusInput" title="Choose a campus...">
                                        <option value="Q">Queens</option>
                                        <option value="S">Staten Island</option>
                                    </select>

                                    <label for="buildingInput">Building</label>
                                    <select class="form-control selectpicker" id="buildingInput" title="Choose a building...">

                                    </select>

                                    <label for="roomInput">Room</label>
                                    <select class="form-control selectpicker" id="roomInput" title="Choose a room...">

                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <h5 class="panel-title"><a href="#professor-select-panel" data-toggle="collapse">Room Selection</a></h5>
                    </div>
                    <div class="panel-collapse collapse" id="professor-select-panel">
                        <div class="panel-body">
                            <form action="" method="get">
                                <div class="form-group">
                                    <label for="professorInput">Building</label>

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
        $("#campusInput").on('change', function() {
            $(".selectpicker").selectpicker();
            $("#buildingInput").load("php/functions.php?ftype=bldg&campus=" + $("#campusInput").val());
            $(".selectpicker").selectpicker('render');
            $(".selectpicker").selectpicker('refresh');
        }).trigger("change");

        $("#buildingInput").on('change', function() {
            $(".selectpicker").selectpicker();
            $("#roomInput").load("php/functions.php?ftype=room&building=" + $("#buildingInput").val());
            $(".selectpicker").selectpicker('render');
            $(".selectpicker").selectpicker('refresh');
        }).trigger("change");
    </script>

</body>

</html>