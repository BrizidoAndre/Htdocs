<?php
/**
 * This is the system landing page
 */
include '../config/Dbh.php';
require '../view/userBoxes.php';
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Landing Page</title>
    <link rel="stylesheet" href="../include/styles.css">
    <link rel="stylesheet" href="joblist.css">
</head>
<body>

<main>
    <h1>Job Indicator</h1>

    <?php
    $jobBoxes = new userBoxes();

    $jobBoxes->loadEmployeesBoxes();

    ?>


</main>

</body>
</html>
