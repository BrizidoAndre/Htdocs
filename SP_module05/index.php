<?php
/**
 * This is the system landing page
 */

include 'config/Dbh.php';

require 'view/jobBox.php';

session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Landing Page</title>

    <!-- Bootstrap core CSS -->
    <link href="include/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="include/styles.css">
</head>
<body>

<main>
    <h1>Job Indicator</h1>

    <?php
    $jobBoxes = new jobBox();

    $jobBoxes->loadJobBoxes();

    ?>


</main>


<script src="include/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
