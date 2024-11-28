<?php

include("mysql_connect.php");

$poster = $conn->query("SELECT moviePoster FROM tbl_movies WHERE movieID = ".$_POST['movieID'])->fetch_column(); // so we can delete the poster file
if ($poster != "icons/missing.png") // so we don't delete the missing icon
    unlink($poster);
$conn->query("DELETE FROM tbl_movies WHERE movieID = ".$_POST['movieID']);

header("location: edit_schedule.php");
die();