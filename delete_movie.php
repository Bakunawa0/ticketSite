<?php

include("mysql_connect.php");

$sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
$schedule = $conn->query($sched_req);