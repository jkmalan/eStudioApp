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
            <?php include ROOT_DIR . 'php/template/calendar_template.php'; ?>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">

</script>

</body>

</html>