<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once './php/initialize.php';

$page_style = "admin.css";
$page_title = "Administration";

if (isset($_POST['submit'])) {
    $uploadDir = ROOT_DIR . 'data/';
    $uploadFile = $uploadDir . basename($_FILES['dataFile']['name']);

    if (move_uploaded_file($_FILES['dataFile']['tmp_name'], $uploadFile)) {
        DBHandler::populateDB($uploadFile);
        $msg = "File successfully uploaded and validated!";
    } else {
        $msg = "File was unable to be uploaded or validated!";
    }
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
                    <span>Administration<span>
                </div>
                <div class="panel-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
                        <div class="form-row">
                            <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                                <label for="dataFile">Select Data File</label>
                                <div>
                                    <input class="form-control" type="file" name="dataFile">
                                </div>
                            </div>
                            <div class="form-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

                            </div>
                        </div>
                        <input class="btn btn-primary col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4" type="submit" name="submit">
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden" id="loading"><img src="img/loading.gif"></div>
    </main>

<?php include ROOT_DIR . 'php/template/footer_template.php'; ?>

<script type="text/javascript">
    $(function() {
        'use strict';

        $(window).on('load', function(e) {
            $('#loading').show();
        });
    });
</script>

</body>

</html>