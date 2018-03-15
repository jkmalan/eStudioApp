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
            <div id="calendar"></div>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">
    var calendar = $("#calendar").calendar({
        tmpl_path: "/tmpls/",
        view: 'week',
        events_source: [{
            "id": 293,
            "title": "Event 1",
            "url": "http://example.com",
            "class": "event-important",
            "start": 1521143344531, // Milliseconds
            "end": 1521143353875 // Milliseconds
        }]
    });
</script>

</body>

</html>