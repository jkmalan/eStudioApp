<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "calendar.css";
$page_title = "Calendar";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $campus = validate($_GET["campus"]);
    $building = validate($_GET["building"]);
    $room = validate($_GET["room"]);
}

?>
<html>

<?php include ROOT_DIR . 'php/template/head_template.php'; ?>

<body>

<?php include ROOT_DIR . 'php/template/navigation_template.php'; ?>

    <main>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            </form>
        </div>
        <div>
            <div id="calendar">

            </div>
        </div>


        <!--
        <div class="container">
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
        </div>-->
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">

</script>

</body>

</html>