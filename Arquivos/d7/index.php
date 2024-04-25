<?php


$day1 = $_GET['date1'];
$day2 = $_GET['date2'];



$day1 = new DateTime($day1);
$day2 = new DateTime($day2);

$interval = date_diff($day1, $day2, true);

echo $interval->format('%a');

