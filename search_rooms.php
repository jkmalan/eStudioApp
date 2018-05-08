<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "scheduler.css";
$page_title = "Scheduler: Room";

$camp_code = $bldg_code = $room_code = "";
$events = array();
if (isset($_GET['submit'])) {
    $camp_code = filter_input(INPUT_GET, 'camp');
    $bldg_code = filter_input(INPUT_GET, 'bldg');
    $room_code = filter_input(INPUT_GET, 'room');
    $events = searchEBR($camp_code, $bldg_code, $room_code);
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
                <span>Room Search<span>
            </div>
            <div class="panel-body">
                <form class="room-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" novalidate>
                    <div class="form-row" id="search-rooms">
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="camp">Select Campus</label>
                            <div id="camp-selection">
                                <select class="form-control" name="camp">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="bldg">Select Building</label>
                            <div id="bldg-selection">
                                <select class="form-control" name="bldg" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <label for="room">Select Room</label>
                            <div id="room-selection">
                                <select class="form-control" name="room" required>

                                </select>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit" name="submit">
                </form>
            </div>
            <hr />
            <div class="panel-body" id="results">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <button class="btn btn-primary" data-calendar-nav="prev">&laquo;</button>
                    </div>
                    <div class="col-xs-4 text-center text-nowrap">
                        <h3></h3>
                    </div>
                    <div class="col-xs-4 text-center">
                        <button class="btn btn-primary" data-calendar-nav="next">&raquo;</button>
                    </div>
                </div>
                <div class="row">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="events-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"></h3>
                </div>
                <div class="modal-body" style="height: 400px">
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">Close</a>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">
    let campInput = $("select[name=camp]");
    let bldgInput = $("select[name=bldg]");
    let roomInput = $("select[name=room]");

    $(function() {
        campInput.load("php/functions.php?ftype=camp");
    });

    let calendar = $("#calendar").calendar({
        tmpl_path: "/tmpls/",
        events_source: function() {return []},
        view: 'week',
        modal: "#events-modal",
        modal_type: 'iframe'
    });

    campInput.on('change', function () {
        bldgInput.load("php/functions.php?ftype=bldg&camp=" + campInput.val());
        roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
    }).trigger("change");

    bldgInput.on('change', function () {
        roomInput.load("php/functions.php?ftype=room&bldg=" + bldgInput.val());
    }).trigger("change");
</script>

</body>

</html>
