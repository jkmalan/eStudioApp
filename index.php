<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "index.css";
$page_title = "Home";

?>
<html>

<?php include ROOT_DIR . 'php/template/head_template.php'; ?>

<body>

<?php include ROOT_DIR . 'php/template/navigation_template.php'; ?>

    <main>
        <div class="container">
            <h1 class="text-center">Welcome to the Landing Page for eStudio!</h1>
        </div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

</body>

</html>