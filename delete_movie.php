<?php

include("mysql_connect.php");

$conn->query("DELETE FROM tbl_movies WHERE movieID = ".$_POST['movieID']);

header("location: edit_schedule.php");
die();