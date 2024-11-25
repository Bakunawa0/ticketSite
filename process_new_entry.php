<?php

include("mysql_connect.php");

$sched_req = "SELECT * FROM tbl_movies ORDER BY timeStart";
$schedule = $conn->query($sched_req);
$postDir = "uploads/"; //poster directory

$newMovie = "INSERT INTO tbl_movies (`movieName`, `rating`, `price`, `timeStart`, `runTime`, `moviePoster`) VALUES (";

$conflict = false; // if there is a schedule conflict
$newMovie .= "'".$_POST['movieName']."','".$_POST['rating']."','".$_POST['price']."','".$_POST['timeStart']."','".$_POST['runTime']."'";

$newEndTime = $_POST['timeStart'] + $_POST['runTime']; // end time of the new movie
while ($row = $schedule->fetch_assoc()) {
    
    $endTime = $row['timeStart'] + $row['runTime'];

    if ($row['timeStart'] <= $_POST['timeStart'] && $_POST['timeStart'] <= $endTime) { // is the starting time of the new movie inside another movie?
        $conflict = true;
    } else if ($row['timeStart'] <= $newEndTime && $newEndTime <= $endTime) { // is the ending of the new movie inside another movie?
        $conflict = true;
    }
}

if (is_null($_POST['moviePoster'])) { // check poster
    $newMovie .= ", NULL)";
} else {
    if (getimagesize($_FILES['moviePoster']['tmp_name']) !== false && $_FILES['moviePoster']['size'] < 10000000) { // if this is truly an image of proper size
        $poster = $postDir.basename($_FILES['moviePoster']['tmp_name']);
        $postDir .= $poster;
        move_uploaded_file($_FILES['moviePoster']['tmp_name'], $postDir);
        $newMovie .= ", '$postDir')";
    } else {
        $newMovie .= ", NULL)";
    }
}

if (!$conflict) {
    $conn->query($newMovie);
}

header("location: edit_schedule.php");
die();