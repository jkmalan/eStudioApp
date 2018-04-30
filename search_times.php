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

$date = $time = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {

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

            </div>
        </div>
    </div>
</main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">

</script>

</body>

</html>
