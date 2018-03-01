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
                <div class="col-xs-6">
                    <p class="well well-lg text-center">Option Top-Left</p>
                </div>
                <div class="col-xs-6">
                    <p class="well well-lg text-center">Option Top-Right</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <p class="well well-lg text-center">Option Bottom-Left</p>
                </div>
                <div class="col-xs-6">
                    <p class="well well-lg text-center">Option Bottom-Right</p>
                </div>
            </div>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

</body>

</html>