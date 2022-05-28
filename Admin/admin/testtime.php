<?php 

$time1 = new DateTime("10:00:01");
$time2 = new DateTime("19:00:02");
$interval = $time1->diff($time2);


echo $total_times = $interval->format('%H Hrs');

?>