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
?>
<html>

<?php include ROOT_DIR . 'php/template/head_template.php'; ?>

<body>

<?php include ROOT_DIR . 'php/template/navigation_template.php'; ?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <button class="btn btn-primary" data-calendar-nav="prev">&laquo;</button>
                </div>
                <div class="col-xs-4 text-center text-nowrap">
                    <h3>Week 23</h3> <!-- Week # -->
                </div>
                <div class="col-xs-4 text-center">
                    <button class="btn btn-primary" data-calendar-nav="next">&raquo;</button>
                </div>
            </div>
            <div class="row">
                <div id="calendar"></div>
            </div>
        </div>

        <<div class="modal fade" id="events-modal">
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
    (function($) {
        let calendar = $("#calendar").calendar({
            tmpl_path: "/tmpls/",
            view: 'week',
            modal: "#events-modal",
            modal_type: "template",
            modal_title: (function(e) { return e.title }),
            events_source: '/php/functions.php?ftype=roomEvents&camp=Q&bldg=MAR&room=137'
        });

        $("button[data-calendar-nav]").each(function() {
            let $this = $(this);
            $this.click(function () {
                calendar.navigate($this.data("calendar-nav"));
            });
        });

        $("#events-modal .modal-header, #events-modal .modal-footer").on("click", function(e) {

        });
    }(jQuery));
</script>

</body>

</html>